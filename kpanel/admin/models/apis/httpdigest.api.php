<?php
/** HTTP Digest authentication class 
Example usage
	// username => hashed password 
	//$users = array( 'username' => md5('username:'.$HTTPDigest->getRealm().':password') ); 
	$HTTPDigest =& new HTTPDigest();
	if ($username = $HTTPDigest->authenticate(array(
		'username' => md5('username:'.$HTTPDigest->getRealm().':password')
	))) {
		echo sprintf('Logged in as "%s"', $username);      
	} else {
		$HTTPDigest->send();
		echo 'Not logged in';
	}

*/

class HttpdigestAPI extends API
{

    /** The Digest opaque value (any string will do, never sent in plain text over the wire).
     * @var str
     */
    var $opaque = 'opaque';

    /** The authentication realm name.
     * @var str
     */    
    var $realm = 'Realm';
    
    /** The base URL of the application, auth data will be used for all resources under this URL.
     * @var str
     */
    var $baseURL = '/';
    
    /** Are passwords stored as an a1 hash (username:realm:password) rather than plain text.
     * @var str
     */
    var $passwordsHashed = TRUE;
    
    /** The private key.
     * @var str
     */
    var $privateKey = 'privatekey';
    
    /** The life of the nonce value in seconds
     * @var int
     */
    var $nonceLife = 300;

    /** Send HTTP Auth header */
    function send()
    {
        header('WWW-Authenticate: Digest '.
            'realm="'.$this->realm.'", '.
            'domain="'.$this->baseURL.'", '.
            'qop=auth, '.
            'algorithm=MD5, '.
            'nonce="'.$this->getNonce().'", '.
            'opaque="'.$this->getOpaque().'"'
        );
        header('HTTP/1.0 401 Unauthorized');
    }
    
    /** Get the HTTP Auth header
     * @return str
     */
    function getAuthHeader()
    {
        if (isset($_SERVER['Authorization'])) {
            return $_SERVER['Authorization'];
        } elseif (function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
            if (isset($headers['Authorization'])) {
                return $headers['Authorization'];
            }
        }
        return NULL;
    }

    /** Authenticate the user and return username on success.
     * @param str[] users Array of username/password pairs
     * @return str
     */
    function authenticate($users)
    {
        $authorization = getAuthHeader();
        if ($authorization) {
            if (substr($authorization, 0, 5) == 'Basic') {
                trigger_error('You are trying to use HTTP Basic authentication but I am expecting HTTP Digest');
                exit;
            }
            if (
                preg_match('/username="([^"]+)"/', $authorization, $username) &&
                preg_match('/nonce="([^"]+)"/', $authorization, $nonce) &&
                preg_match('/response="([^"]+)"/', $authorization, $response) &&
                preg_match('/opaque="([^"]+)"/', $authorization, $opaque) &&
                preg_match('/uri="([^"]+)"/', $authorization, $uri)
            ) {
                $username = $username[1];
                $requestURI = $_SERVER['REQUEST_URI'];
                if (strpos($requestURI, '?') !== FALSE) { // hack for IE which does not pass querystring in URI element of Digest string or in response hash
                    $requestURI = substr($requestURI, 0, strlen($uri[1]));
                }
                if (
                    isset($users[$username]) &&
                    $opaque[1] == $this->getOpaque() &&
                    $uri[1] == $requestURI &&
                    $nonce[1] == $this->getNonce()
                ) {
                    $passphrase = $users[$username];
                    if ($this->passwordsHashed) {
                        $a1 = $passphrase;
                    } else {
                        $a1 = md5($username.':'.$this->getRealm().':'.$passphrase);
                    }
                    $a2 = md5($_SERVER['REQUEST_METHOD'].':'.$requestURI);
                    if (
                        preg_match('/qop="?([^,\s"]+)/', $authorization, $qop) &&
                        preg_match('/nc=([^,\s"]+)/', $authorization, $nc) &&
                        preg_match('/cnonce="([^"]+)"/', $authorization, $cnonce)
                    ) {
                        $expectedResponse = md5($a1.':'.$nonce[1].':'.$nc[1].':'.$cnonce[1].':'.$qop[1].':'.$a2);
                    } else {
                        $expectedResponse = md5($a1.':'.$nonce[1].':'.$a2);   
                    }
                    if ($response[1] == $expectedResponse) {
                        return $username;
                    }
                }
            }
        } else {
            trigger_error('HTTP Digest headers not being passed to PHP by the server, unable to authenticate user');
            exit;
        }
        return NULL;
    }
    
    /** Get nonce value for HTTP Digest.
     * @return str
     */
    function getNonce() {
        $time = ceil(time() / $this->nonceLife) * $this->nonceLife;
        return md5(date('Y-m-d H:i', $time).':'.$_SERVER['REMOTE_ADDR'].':'.$this->privateKey);
    }

    /** Get opaque value for HTTP Digest.
     * @return str
     */
    function getOpaque()
    {
        return md5($this->opaque);
    }
    
    /** Get realm for HTTP Digest taking PHP safe mode into account.
     * @return str
     */
    function getRealm()
    {
        if (ini_get('safe_mode')) {
            return $this->realm.'-'.getmyuid();
        } else {
            return $this->realm;
        }    
    }

}
?>