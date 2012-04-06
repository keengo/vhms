
window.undefined = window.undefined;
function jQuery(a,c) {
	if ( a && a.constructor == Function && jQuery.fn.ready )
		return jQuery(document).ready(a);
	a = a || jQuery.context || document;
	if ( a.jquery )
		return jQuery( jQuery.merge( a, [] ) );
	if ( c && c.jquery )
		return jQuery( c ).find(a);
	if ( window == this )
		return new jQuery(a,c);
	var m = /^[^<]*(<.+>)[^>]*$/.exec(a);
	if ( m ) a = jQuery.clean( [ m[1] ] );
	this.get( a.constructor == Array || a.length && !a.nodeType && a[0] != undefined && a[0].nodeType ?
		jQuery.merge( a, [] ) :
		jQuery.find( a, c ) );
	var fn = arguments[ arguments.length - 1 ];
	if ( fn && fn.constructor == Function )
		this.each(fn);
}

if ( typeof $ != "undefined" )
	jQuery._$ = $;
var $ = jQuery;
jQuery.fn = jQuery.prototype = {
	jquery: "$Rev: 276 $",
	size: function() {
		return this.length;
	},
	get: function( num ) {
		if ( num && num.constructor == Array ) {
			this.length = 0;
			[].push.apply( this, num );
			return this;
		} else
			return num == undefined ?
				jQuery.merge( this, [] ) :
				this[num];
	},
	each: function( fn, args ) {
		return jQuery.each( this, fn, args );
	},
	index: function( obj ) {
		var pos = -1;
		this.each(function(i){
			if ( this == obj ) pos = i;
		});
		return pos;
	},
	attr: function( key, value, type ) {
		return key.constructor != String || value != undefined ?
			this.each(function(){
				if ( value == undefined )
					for ( var prop in key )
						jQuery.attr(
							type ? this.style : this,
							prop, key[prop]
						);
				else
					jQuery.attr(
						type ? this.style : this,
						key, value
					);
			}) :
			jQuery[ type || "attr" ]( this[0], key );
	},
	css: function( key, value ) {
		return this.attr( key, value, "curCSS" );
	},
	text: function(e) {
		e = e || this;
		var t = "";
		for ( var j = 0; j < e.length; j++ ) {
			var r = e[j].childNodes;
			for ( var i = 0; i < r.length; i++ )
				if ( r[i].nodeType != 8 )
					t += r[i].nodeType != 1 ?
						r[i].nodeValue : jQuery.fn.text([ r[i] ]);
		}
		return t;
	},
	wrap: function() {
		var a = jQuery.clean(arguments);
		return this.each(function(){
			var b = a[0].cloneNode(true);
			this.parentNode.insertBefore( b, this );
			while ( b.firstChild )
				b = b.firstChild;
			b.appendChild( this );
		});
	},
	append: function() {
		return this.domManip(arguments, true, 1, function(a){
			this.appendChild( a );
		});
	},
	prepend: function() {
		return this.domManip(arguments, true, -1, function(a){
			this.insertBefore( a, this.firstChild );
		});
	},
	before: function() {
		return this.domManip(arguments, false, 1, function(a){
			this.parentNode.insertBefore( a, this );
		});
	},
	after: function() {
		return this.domManip(arguments, false, -1, function(a){
			this.parentNode.insertBefore( a, this.nextSibling );
		});
	},
	end: function() {
		return this.get( this.stack.pop() );
	},
	find: function(t) {
		return this.pushStack( jQuery.map( this, function(a){
			return jQuery.find(t,a);
		}), arguments );
	},
	clone: function(deep) {
		return this.pushStack( jQuery.map( this, function(a){
			return a.cloneNode( deep != undefined ? deep : true );
		}), arguments );
	},
	filter: function(t) {
		return this.pushStack(
			t.constructor == Array &&
			jQuery.map(this,function(a){
				for ( var i = 0; i < t.length; i++ )
					if ( jQuery.filter(t[i],[a]).r.length )
						return a;
			}) ||
			t.constructor == Boolean &&
			( t ? this.get() : [] ) ||

			t.constructor == Function &&
			jQuery.grep( this, t ) ||

			jQuery.filter(t,this).r, arguments );
	},
	not: function(t) {
		return this.pushStack( t.constructor == String ?
			jQuery.filter(t,this,false).r :
			jQuery.grep(this,function(a){ return a != t; }), arguments );
	},
	add: function(t) {
		return this.pushStack( jQuery.merge( this, t.constructor == String ?
			jQuery.find(t) : t.constructor == Array ? t : [t] ), arguments );
	},
	is: function(expr) {
		return expr ? jQuery.filter(expr,this).r.length > 0 : false;
	},
	domManip: function(args, table, dir, fn){
		var clone = this.size() > 1;
		var a = jQuery.clean(args);

		return this.each(function(){
			var obj = this;
			if ( table && this.nodeName == "TABLE" && a[0].nodeName != "THEAD" ) {
				var tbody = this.getElementsByTagName("tbody");

				if ( !tbody.length ) {
					obj = document.createElement("tbody");
					this.appendChild( obj );
				} else
					obj = tbody[0];
			}

			for ( var i = ( dir < 0 ? a.length - 1 : 0 );
				i != ( dir < 0 ? dir : a.length ); i += dir ) {
					fn.apply( obj, [ clone ? a[i].cloneNode(true) : a[i] ] );
			}
		});
	},
	pushStack: function(a,args) {
		var fn = args && args[args.length-1];

		if ( !fn || fn.constructor != Function ) {
			if ( !this.stack ) this.stack = [];
			this.stack.push( this.get() );
			this.get( a );
		} else {
			var old = this.get();
			this.get( a );
			if ( fn.constructor == Function )
				this.each( fn );
			this.get( old );
		}

		return this;
	}
};


jQuery.extend = jQuery.fn.extend = function(obj,prop) {
	if ( !prop ) { prop = obj; obj = this; }
	for ( var i in prop ) obj[i] = prop[i];
	return obj;
};

jQuery.extend({
	init: function(){
		jQuery.initDone = true;

		jQuery.each( jQuery.macros.axis, function(i,n){
			jQuery.fn[ i ] = function(a) {
				var ret = jQuery.map(this,n);
				if ( a && a.constructor == String )
					ret = jQuery.filter(a,ret).r;
				return this.pushStack( ret, arguments );
			};
		});

		jQuery.each( jQuery.macros.to, function(i,n){
			jQuery.fn[ i ] = function(){
				var a = arguments;
				return this.each(function(){
					for ( var j = 0; j < a.length; j++ )
						jQuery(a[j])[n]( this );
				});
			};
		});

		jQuery.each( jQuery.macros.each, function(i,n){
			jQuery.fn[ i ] = function() {
				return this.each( n, arguments );
			};
		});

		jQuery.each( jQuery.macros.filter, function(i,n){
			jQuery.fn[ n ] = function(num,fn) {
				return this.filter( ":" + n + "(" + num + ")", fn );
			};
		});

		jQuery.each( jQuery.macros.attr, function(i,n){
			n = n || i;
			jQuery.fn[ i ] = function(h) {
				return h == undefined ?
					this.length ? this[0][n] : null :
					this.attr( n, h );
			};
		});

		jQuery.each( jQuery.macros.css, function(i,n){
			jQuery.fn[ n ] = function(h) {
				return h == undefined ?
					( this.length ? jQuery.css( this[0], n ) : null ) :
					this.css( n, h );
			};
		});

	},

	each: function( obj, fn, args ) {
		if ( obj.length == undefined )
			for ( var i in obj )
				fn.apply( obj[i], args || [i, obj[i]] );
		else
			for ( var i = 0; i < obj.length; i++ )
				fn.apply( obj[i], args || [i, obj[i]] );
		return obj;
	},

	className: {
		add: function(o,c){
			if (jQuery.className.has(o,c)) return;
			o.className += ( o.className ? " " : "" ) + c;
		},
		remove: function(o,c){
			o.className = !c ? "" :
				o.className.replace(
					new RegExp("(^|\\s*\\b[^-])"+c+"($|\\b(?=[^-]))", "g"), "");
		},
		has: function(e,a) {
			if ( e.className != undefined )
				e = e.className;
			return new RegExp("(^|\\s)" + a + "(\\s|$)").test(e);
		}
	},

	
	swap: function(e,o,f) {
		for ( var i in o ) {
			e.style["old"+i] = e.style[i];
			e.style[i] = o[i];
		}
		f.apply( e, [] );
		for ( var i in o )
			e.style[i] = e.style["old"+i];
	},

	css: function(e,p) {
		if ( p == "height" || p == "width" ) {
			var old = {}, oHeight, oWidth, d = ["Top","Bottom","Right","Left"];

			for ( var i in d ) {
				old["padding" + d[i]] = 0;
				old["border" + d[i] + "Width"] = 0;
			}

			jQuery.swap( e, old, function() {
				if (jQuery.css(e,"display") != "none") {
					oHeight = e.offsetHeight;
					oWidth = e.offsetWidth;
				} else {
					e = jQuery(e.cloneNode(true)).css({
						visibility: "hidden", position: "absolute", display: "block", right: "0", left: "0"
					}).appendTo(e.parentNode)[0];

					var parPos = jQuery.css(e.parentNode,"position");
					if ( parPos == "" || parPos == "static" )
						e.parentNode.style.position = "relative";

					oHeight = e.clientHeight;
					oWidth = e.clientWidth;

					if ( parPos == "" || parPos == "static" )
						e.parentNode.style.position = "static";

					e.parentNode.removeChild(e);
				}
			});

			return p == "height" ? oHeight : oWidth;
		} else if ( p == "opacity" && jQuery.browser.msie )
			return parseFloat( jQuery.curCSS(e,"filter").replace(/[^0-9.]/,"") ) || 1;

		return jQuery.curCSS( e, p );
	},

	curCSS: function(elem, prop, force) {
		var ret;

		if (!force && elem.style[prop]) {

			ret = elem.style[prop];

		} else if (elem.currentStyle) {

			var newProp = prop.replace(/\-(\w)/g,function(m,c){return c.toUpperCase();});
			ret = elem.currentStyle[prop] || elem.currentStyle[newProp];

		} else if (document.defaultView && document.defaultView.getComputedStyle) {

			prop = prop.replace(/([A-Z])/g,"-$1").toLowerCase();
			var cur = document.defaultView.getComputedStyle(elem, null);

			if ( cur )
				ret = cur.getPropertyValue(prop);
			else if ( prop == 'display' )
				ret = 'none';
			else
				jQuery.swap(elem, { display: 'block' }, function() {
					ret = document.defaultView.getComputedStyle(this,null).getPropertyValue(prop);
				});

		}
		return ret;
	},
	clean: function(a) {
		var r = [];
		for ( var i = 0; i < a.length; i++ ) {
			if ( a[i].constructor == String ) {

				var table = "";

				if ( !a[i].indexOf("<thead") || !a[i].indexOf("<tbody") ) {
					table = "thead";
					a[i] = "<table>" + a[i] + "</table>";
				} else if ( !a[i].indexOf("<tr") ) {
					table = "tr";
					a[i] = "<table>" + a[i] + "</table>";
				} else if ( !a[i].indexOf("<td") || !a[i].indexOf("<th") ) {
					table = "td";
					a[i] = "<table><tbody><tr>" + a[i] + "</tr></tbody></table>";
				}

				var div = document.createElement("div");
				div.innerHTML = a[i];

				if ( table ) {
					div = div.firstChild;
					if ( table != "thead" ) div = div.firstChild;
					if ( table == "td" ) div = div.firstChild;
				}

				for ( var j = 0; j < div.childNodes.length; j++ )
					r.push( div.childNodes[j] );
				} else if ( a[i].jquery || a[i].length && !a[i].nodeType )
					for ( var k = 0; k < a[i].length; k++ )
						r.push( a[i][k] );
				else if ( a[i] !== null )
					r.push(	a[i].nodeType ? a[i] : document.createTextNode(a[i].toString()) );
		}
		return r;
	},
	expr: {
		"": "m[2]== '*'||a.nodeName.toUpperCase()==m[2].toUpperCase()",
		"#": "a.getAttribute('id')&&a.getAttribute('id')==m[2]",
		":": {
			lt: "i<m[3]-0",
			gt: "i>m[3]-0",
			nth: "m[3]-0==i",
			eq: "m[3]-0==i",
			first: "i==0",
			last: "i==r.length-1",
			even: "i%2==0",
			odd: "i%2",
			"nth-child": "jQuery.sibling(a,m[3]).cur",
			"first-child": "jQuery.sibling(a,0).cur",
			"last-child": "jQuery.sibling(a,0).last",
			"only-child": "jQuery.sibling(a).length==1",
			parent: "a.childNodes.length",
			empty: "!a.childNodes.length",
			contains: "(a.innerText||a.innerHTML).indexOf(m[3])>=0",
			visible: "a.type!='hidden'&&jQuery.css(a,'display')!='none'&&jQuery.css(a,'visibility')!='hidden'",
			hidden: "a.type=='hidden'||jQuery.css(a,'display')=='none'||jQuery.css(a,'visibility')=='hidden'",
			enabled: "!a.disabled",
			disabled: "a.disabled",
			checked: "a.checked",
			selected: "a.selected"
		},
		".": "jQuery.className.has(a,m[2])",
		"@": {
			"=": "z==m[4]",
			"!=": "z!=m[4]",
			"^=": "!z.indexOf(m[4])",
			"$=": "z.substr(z.length - m[4].length,m[4].length)==m[4]",
			"*=": "z.indexOf(m[4])>=0",
			"": "z"
		},
		"[": "jQuery.find(m[2],a).length"
	},

	token: [
		"\\.\\.|/\\.\\.", "a.parentNode",
		">|/", "jQuery.sibling(a.firstChild)",
		"\\+", "jQuery.sibling(a).next",
		"~", function(a){
			var r = [];
			var s = jQuery.sibling(a);
			if ( s.n > 0 )
				for ( var i = s.n; i < s.length; i++ )
					r.push( s[i] );
			return r;
		}
	],
	find: function( t, context ) {
		if ( context && context.nodeType == undefined )
			context = null;
		context = context || jQuery.context || document;
		if ( t.constructor != String ) return [t];
		if ( !t.indexOf("//") ) {
			context = context.documentElement;
			t = t.substr(2,t.length);
		} else if ( !t.indexOf("/") ) {
			context = context.documentElement;
			t = t.substr(1,t.length);
			if ( t.indexOf("/") >= 1 )
				t = t.substr(t.indexOf("/"),t.length);
		}
		var ret = [context];
		var done = [];
		var last = null;
		while ( t.length > 0 && last != t ) {
			var r = [];
			last = t;
			t = jQuery.trim(t).replace( /^\/\//i, "" );
			var foundToken = false;
			for ( var i = 0; i < jQuery.token.length; i += 2 ) {
				if ( foundToken ) continue;
				var re = new RegExp("^(" + jQuery.token[i] + ")");
				var m = re.exec(t);
				if ( m ) {
					r = ret = jQuery.map( ret, jQuery.token[i+1] );
					t = jQuery.trim( t.replace( re, "" ) );
					foundToken = true;
				}
			}
			if ( !foundToken ) {
				if ( !t.indexOf(",") || !t.indexOf("|") ) {
					if ( ret[0] == context ) ret.shift();
					done = jQuery.merge( done, ret );
					r = ret = [context];
					t = " " + t.substr(1,t.length);
				} else {
					var re2 = /^([#.]?)([a-z0-9\\*_-]*)/i;
					var m = re2.exec(t);
					if ( m[1] == "#" ) {
						var oid = document.getElementById(m[2]);
						r = ret = oid ? [oid] : [];
						t = t.replace( re2, "" );
					} else {
						if ( !m[2] || m[1] == "." ) m[2] = "*";
						for ( var i = 0; i < ret.length; i++ )
							r = jQuery.merge( r,
								m[2] == "*" ?
									jQuery.getAll(ret[i]) :
									ret[i].getElementsByTagName(m[2])
							);
					}
				}
			}
			if ( t ) {
				var val = jQuery.filter(t,r);
				ret = r = val.r;
				t = jQuery.trim(val.t);
			}
		}
		if ( ret && ret[0] == context ) ret.shift();
		done = jQuery.merge( done, ret );
		return done;
	},
	getAll: function(o,r) {
		r = r || [];
		var s = o.childNodes;
		for ( var i = 0; i < s.length; i++ )
			if ( s[i].nodeType == 1 ) {
				r.push( s[i] );
				jQuery.getAll( s[i], r );
			}
		return r;
	},
	attr: function(elem, name, value){
		var fix = {
			"for": "htmlFor",
			"class": "className",
			"float": "cssFloat",
			innerHTML: "innerHTML",
			className: "className",
			value: "value",
			disabled: "disabled",
			checked: "checked"
		};
		if ( fix[name] ) {
			if ( value != undefined ) elem[fix[name]] = value;
			return elem[fix[name]];
		} else if ( elem.getAttribute ) {
			if ( value != undefined ) elem.setAttribute( name, value );
			return elem.getAttribute( name, 2 );
		} else {
			name = name.replace(/-([a-z])/ig,function(z,b){return b.toUpperCase();});
			if ( value != undefined ) elem[name] = value;
			return elem[name];
		}
	},
	parse: [
		[ "\\[ *(@)S *([!*$^=]*) *Q\\]", 1 ],
		[ "(\\[)Q\\]", 0 ],
		[ "(:)S\\(Q\\)", 0 ],
		[ "([:.#]*)S", 0 ]
	],
	filter: function(t,r,not) {
		var g = not !== false ? jQuery.grep :
			function(a,f) {return jQuery.grep(a,f,true);};
		while ( t && /^[a-z[({<*:.#]/i.test(t) ) {
			var p = jQuery.parse;
			for ( var i = 0; i < p.length; i++ ) {
				var re = new RegExp( "^" + p[i][0]
					.replace( 'S', "([a-z*_-][a-z0-9_-]*)" )
					.replace( 'Q', " *'?\"?([^'\"]*?)'?\"? *" ), "i" );
				var m = re.exec( t );
				if ( m ) {
					if ( p[i][1] )
						m = ["", m[1], m[3], m[2], m[4]];
					t = t.replace( re, "" );
					break;
				}
			}
			if ( m[1] == ":" && m[2] == "not" )
				r = jQuery.filter(m[3],r,false).r;
			else {
				var f = jQuery.expr[m[1]];
				if ( f.constructor != String )
					f = jQuery.expr[m[1]][m[2]];
				eval("f = function(a,i){" +
					( m[1] == "@" ? "z=jQuery.attr(a,m[3]);" : "" ) +
					"return " + f + "}");
				r = g( r, f );
			}
		}
		return { r: r, t: t };
	},
	trim: function(t){
		return t.replace(/^\s+|\s+$/g, "");
	},
	parents: function( elem ){
		var matched = [];
		var cur = elem.parentNode;
		while ( cur && cur != document ) {
			matched.push( cur );
			cur = cur.parentNode;
		}
		return matched;
	},
	sibling: function(elem, pos, not) {
		var elems = [];

		var siblings = elem.parentNode.childNodes;
		for ( var i = 0; i < siblings.length; i++ ) {
			if ( not === true && siblings[i] == elem ) continue;

			if ( siblings[i].nodeType == 1 )
				elems.push( siblings[i] );
			if ( siblings[i] == elem )
				elems.n = elems.length - 1;
		}

		return jQuery.extend( elems, {
			last: elems.n == elems.length - 1,
			cur: pos == "even" && elems.n % 2 == 0 || pos == "odd" && elems.n % 2 || elems[pos] == elem,
			prev: elems[elems.n - 1],
			next: elems[elems.n + 1]
		});
	},
	merge: function(first, second) {
		var result = [];
		for ( var k = 0; k < first.length; k++ )
			result[k] = first[k];
		for ( var i = 0; i < second.length; i++ ) {
			var noCollision = true;
			for ( var j = 0; j < first.length; j++ )
				if ( second[i] == first[j] )
					noCollision = false;
			if ( noCollision )
				result.push( second[i] );
		}
		return result;
	},
	grep: function(elems, fn, inv) {
		if ( fn.constructor == String )
			fn = new Function("a","i","return " + fn);
		var result = [];
		for ( var i = 0; i < elems.length; i++ )
			if ( !inv && fn(elems[i],i) || inv && !fn(elems[i],i) )
				result.push( elems[i] );
		return result;
	},
	map: function(elems, fn) {
		if ( fn.constructor == String )
			fn = new Function("a","return " + fn);
		var result = [];
		for ( var i = 0; i < elems.length; i++ ) {
			var val = fn(elems[i],i);
			if ( val !== null && val != undefined ) {
				if ( val.constructor != Array ) val = [val];
				result = jQuery.merge( result, val );
			}
		}
		return result;
	},
	event: {
		add: function(element, type, handler) {
			if ( jQuery.browser.msie && element.setInterval != undefined )
				element = window;
			if ( !handler.guid )
				handler.guid = this.guid++;
			if (!element.events)
				element.events = {};
			var handlers = element.events[type];
			if (!handlers) {
				handlers = element.events[type] = {};
				if (element["on" + type])
					handlers[0] = element["on" + type];
			}
			handlers[handler.guid] = handler;
			element["on" + type] = this.handle;
			if (!this.global[type])
				this.global[type] = [];
			this.global[type].push( element );
		},
		guid: 1,
		global: {},
		remove: function(element, type, handler) {
			if (element.events)
				if (type && element.events[type])
					if ( handler )
						delete element.events[type][handler.guid];
					else
						for ( var i in element.events[type] )
							delete element.events[type][i];
				else
					for ( var j in element.events )
						this.remove( element, j );
		},
		trigger: function(type,data,element) {
			data = data || [];
			if ( !element ) {
				var g = this.global[type];
				if ( g )
					for ( var i = 0; i < g.length; i++ )
						this.trigger( type, data, g[i] );
			} else if ( element["on" + type] ) {
				data.unshift( this.fix({ type: type, target: element }) );
				element["on" + type].apply( element, data );
			}
		},
		handle: function(event) {
			if ( typeof jQuery == "undefined" ) return;
			event = event || jQuery.event.fix( window.event );
			if ( !event ) return;
			var returnValue = true;
			var c = this.events[event.type];
			for ( var j in c ) {
				if ( c[j].apply( this, [event] ) === false ) {
					event.preventDefault();
					event.stopPropagation();
					returnValue = false;
				}
			}
			return returnValue;
		},
		fix: function(event) {
			if ( event ) {
				event.preventDefault = function() {
					this.returnValue = false;
				};
				event.stopPropagation = function() {
					this.cancelBubble = true;
				};
			}
			return event;
		}
	}
});
new function() {
	var b = navigator.userAgent.toLowerCase();
	jQuery.browser = {
		safari: /webkit/.test(b),
		opera: /opera/.test(b),
		msie: /msie/.test(b) && !/opera/.test(b),
		mozilla: /mozilla/.test(b) && !/(compatible|webkit)/.test(b)
	};
	jQuery.boxModel = !jQuery.browser.msie || document.compatMode == "CSS1Compat";
};
jQuery.macros = {
	to: {
		appendTo: "append",
		prependTo: "prepend",
		insertBefore: "before",
		insertAfter: "after"
	},
	css: "width,height,top,left,position,float,overflow,color,background".split(","),
	filter: [ "eq", "lt", "gt", "contains" ],
	attr: {
		val: "value",
		html: "innerHTML",
		id: null,
		title: null,
		name: null,
		href: null,
		src: null,
		rel: null
	},
	axis: {
		parent: "a.parentNode",
		ancestors: jQuery.parents,
		parents: jQuery.parents,
		next: "jQuery.sibling(a).next",
		prev: "jQuery.sibling(a).prev",
		siblings: jQuery.sibling,
		children: "jQuery.sibling(a.firstChild)"
	},
	each: {
		removeAttr: function( key ) {
			this.removeAttribute( key );
		},
		show: function(){
			this.style.display = this.oldblock ? this.oldblock : "";
			if ( jQuery.css(this,"display") == "none" )
				this.style.display = "block";
		},
		hide: function(){
			this.oldblock = this.oldblock || jQuery.css(this,"display");
			if ( this.oldblock == "none" )
				this.oldblock = "block";
			this.style.display = "none";
		},
		toggle: function(){
			jQuery(this)[ jQuery(this).is(":hidden") ? "show" : "hide" ].apply( jQuery(this), arguments );
		},
		addClass: function(c){
			jQuery.className.add(this,c);
		},
		removeClass: function(c){
			jQuery.className.remove(this,c);
		},
		toggleClass: function( c ){
			jQuery.className[ jQuery.className.has(this,c) ? "remove" : "add" ](this,c);
		},
		remove: function(a){
			if ( !a || jQuery.filter( a, [this] ).r )
				this.parentNode.removeChild( this );
		},
		empty: function(){
			while ( this.firstChild )
				this.removeChild( this.firstChild );
		},
		bind: function( type, fn ) {
			if ( fn.constructor == String )
				fn = new Function("e", ( !fn.indexOf(".") ? "jQuery(this)" : "return " ) + fn);
			jQuery.event.add( this, type, fn );
		},
		unbind: function( type, fn ) {
			jQuery.event.remove( this, type, fn );
		},
		trigger: function( type, data ) {
			jQuery.event.trigger( type, data, this );
		}
	}
};
jQuery.init();
jQuery.fn.extend({
	_toggle: jQuery.fn.toggle,
	toggle: function(a,b) {
		return a && b && a.constructor == Function && b.constructor == Function ? this.click(function(e){
			this.last = this.last == a ? b : a;
			e.preventDefault();
			return this.last.apply( this, [e] ) || false;
		}) :
		this._toggle.apply( this, arguments );
	},
	hover: function(f,g) {
		function handleHover(e) {
			var p = (e.type == "mouseover" ? e.fromElement : e.toElement) || e.relatedTarget;
			while ( p && p != this ) p = p.parentNode;
			if ( p == this ) return false;
			return (e.type == "mouseover" ? f : g).apply(this, [e]);
		}
		return this.mouseover(handleHover).mouseout(handleHover);
	},
	ready: function(f) {
		if ( jQuery.isReady )
			f.apply( document );
		else {
			jQuery.readyList.push( f );
		}
		return this;
	}
});

jQuery.extend({
	isReady: false,
	readyList: [],
	ready: function() {
		if ( !jQuery.isReady ) {
			jQuery.isReady = true;
			if ( jQuery.readyList ) {
				for ( var i = 0; i < jQuery.readyList.length; i++ )
					jQuery.readyList[i].apply( document );
				jQuery.readyList = null;
			}
		}
	}
});

new function(){
	var e = ("blur,focus,load,resize,scroll,unload,click,dblclick," +
		"mousedown,mouseup,mousemove,mouseover,mouseout,change,reset,select," + 
		"submit,keydown,keypress,keyup,error").split(",");
	for ( var i = 0; i < e.length; i++ ) new function(){
		var o = e[i];
		jQuery.fn[o] = function(f){
			return f ? this.bind(o, f) : this.trigger(o);
		};
		jQuery.fn["un"+o] = function(f){ return this.unbind(o, f); };
		jQuery.fn["one"+o] = function(f){
			return this.each(function(){
				var count = 0;
				jQuery.event.add( this, o, function(e){
					if ( count++ ) return;
					return f.apply(this, [e]);
				});
			});
		};
	};
	if ( jQuery.browser.mozilla || jQuery.browser.opera ) {
		document.addEventListener( "DOMContentLoaded", jQuery.ready, false );
	} else if ( jQuery.browser.msie ) {
		document.write("<scr" + "ipt id=__ie_init defer=true " + 
			"src=//:><\/script>");
		var script = document.getElementById("__ie_init");
		script.onreadystatechange = function() {
			if ( this.readyState != "complete" ) return;
			this.parentNode.removeChild( this );
			jQuery.ready();
		};
		script = null;
	} else if ( jQuery.browser.safari ) {
		jQuery.safariTimer = setInterval(function(){
			if ( document.readyState == "loaded" || 
				document.readyState == "complete" ) {
				clearInterval( jQuery.safariTimer );
				jQuery.safariTimer = null;
				jQuery.ready();
			}
		}, 10);
	} 
	jQuery.event.add( window, "load", jQuery.ready );
};
jQuery.fn.extend({
	_show: jQuery.fn.show,
	
	show: function(speed,callback){
		return speed ? this.animate({
			height: "show", width: "show", opacity: "show"
		}, speed, callback) : this._show();
	},
	_hide: jQuery.fn.hide,
	hide: function(speed,callback){
		return speed ? this.animate({
			height: "hide", width: "hide", opacity: "hide"
		}, speed, callback) : this._hide();
	},
	slideDown: function(speed,callback){
		return this.animate({height: "show"}, speed, callback);
	},
	slideUp: function(speed,callback){
		return this.animate({height: "hide"}, speed, callback);
	},
	slideToggle: function(speed,callback){
		return this.each(function(){
			var state = $(this).is(":hidden") ? "show" : "hide";
			$(this).animate({height: state}, speed, callback);
		});
	},
	fadeIn: function(speed,callback){
		return this.animate({opacity: "show"}, speed, callback);
	},
	fadeOut: function(speed,callback){
		return this.animate({opacity: "hide"}, speed, callback);
	},
	fadeTo: function(speed,to,callback){
		return this.animate({opacity: to}, speed, callback);
	},
	animate: function(prop,speed,callback) {
		return this.queue(function(){
			this.curAnim = prop;
			for ( var p in prop ) {
				var e = new jQuery.fx( this, jQuery.speed(speed,callback), p );
				if ( prop[p].constructor == Number )
					e.custom( e.cur(), prop[p] );
				else
					e[ prop[p] ]( prop );
			}
		});
	},
	queue: function(type,fn){
		if ( !fn ) {
			fn = type;
			type = "fx";
		}
		return this.each(function(){
			if ( !this.queue )
				this.queue = {};
			if ( !this.queue[type] )
				this.queue[type] = [];
			this.queue[type].push( fn );
			if ( this.queue[type].length == 1 )
				fn.apply(this);
		});
	}
});
jQuery.extend({
	setAuto: function(e,p) {
		if ( e.notAuto ) return;
		if ( p == "height" && e.scrollHeight != parseInt(jQuery.curCSS(e,p)) ) return;
		if ( p == "width" && e.scrollWidth != parseInt(jQuery.curCSS(e,p)) ) return;
		var a = e.style[p];
		var o = jQuery.curCSS(e,p,1);
		if ( p == "height" && e.scrollHeight != o ||
			p == "width" && e.scrollWidth != o ) return;
		e.style[p] = e.currentStyle ? "" : "auto";
		var n = jQuery.curCSS(e,p,1);
		if ( o != n && n != "auto" ) {
			e.style[p] = a;
			e.notAuto = true;
		}
	},
	speed: function(s,o) {
		o = o || {};
		if ( o.constructor == Function )
			o = { complete: o };
		var ss = { slow: 600, fast: 200 };
		o.duration = (s && s.constructor == Number ? s : ss[s]) || 400;
		o.oldComplete = o.complete;
		o.complete = function(){
			jQuery.dequeue(this, "fx");
			if ( o.oldComplete && o.oldComplete.constructor == Function )
				o.oldComplete.apply( this );
		};
		return o;
	},
	queue: {},
	dequeue: function(elem,type){
		type = type || "fx";
		if ( elem.queue && elem.queue[type] ) {
			elem.queue[type].shift();
			var f = elem.queue[type][0];
			if ( f ) f.apply( elem );
		}
	},
	fx: function( elem, options, prop ){
		var z = this;
		z.o = {
			duration: options.duration || 400,
			complete: options.complete,
			step: options.step
		};
		z.el = elem;
		var y = z.el.style;
		z.a = function(){
			if ( options.step )
				options.step.apply( elem, [ z.now ] );
			if ( prop == "opacity" ) {
				if (jQuery.browser.mozilla && z.now == 1) z.now = 0.9999;
				if (window.ActiveXObject)
					y.filter = "alpha(opacity=" + z.now*100 + ")";
				else
					y.opacity = z.now;
			} else if ( parseInt(z.now) )
				y[prop] = parseInt(z.now) + "px";
			y.display = "block";
		};
		z.max = function(){
			return parseFloat( jQuery.css(z.el,prop) );
		};
		z.cur = function(){
			var r = parseFloat( jQuery.curCSS(z.el, prop) );
			return r && r > -10000 ? r : z.max();
		};
		z.custom = function(from,to){
			z.startTime = (new Date()).getTime();
			z.now = from;
			z.a();
	
			z.timer = setInterval(function(){
				z.step(from, to);
			}, 13);
		};
		z.show = function( p ){
			if ( !z.el.orig ) z.el.orig = {};
			z.el.orig[prop] = this.cur();
			z.custom( 0, z.el.orig[prop] );
			if ( prop != "opacity" )
				y[prop] = "1px";
		};
		z.hide = function(){
			if ( !z.el.orig ) z.el.orig = {};
			z.el.orig[prop] = this.cur();
			z.o.hide = true;
			z.custom(z.el.orig[prop], 0);
		};
		if ( jQuery.browser.msie && !z.el.currentStyle.hasLayout )
			y.zoom = "1";
		if ( !z.el.oldOverlay )
			z.el.oldOverflow = jQuery.css( z.el, "overflow" );
		y.overflow = "hidden";
		z.step = function(firstNum, lastNum){
			var t = (new Date()).getTime();
			if (t > z.o.duration + z.startTime) {
				clearInterval(z.timer);
				z.timer = null;
				z.now = lastNum;
				z.a();
				z.el.curAnim[ prop ] = true;
				var done = true;
				for ( var i in z.el.curAnim )
					if ( z.el.curAnim[i] !== true )
						done = false;
				if ( done ) {
					y.overflow = z.el.oldOverflow;
					if ( z.o.hide ) 
						y.display = 'none';
					if ( z.o.hide ) {
						for ( var p in z.el.curAnim ) {
							y[ p ] = z.el.orig[p] + ( p == "opacity" ? "" : "px" );
							if ( p == 'height' || p == 'width' )
								jQuery.setAuto( z.el, p );
						}
					}
				}
				if( done && z.o.complete && z.o.complete.constructor == Function )
					z.o.complete.apply( z.el );
			} else {
				var p = (t - this.startTime) / z.o.duration;
				z.now = ((-Math.cos(p*Math.PI)/2) + 0.5) * (lastNum-firstNum) + firstNum;
				z.a();
			}
		};
	
	}

});
jQuery.fn.loadIfModified = function( url, params, callback ) {
	this.load( url, params, callback, 1 );
};
jQuery.fn.load = function( url, params, callback, ifModified ) {
	if ( url.constructor == Function )
		return this.bind("load", url);
	callback = callback || function(){};
	var type = "GET";
	if ( params ) {
		if ( params.constructor == Function ) {
			callback = params;
			params = null;
		} else {
			params = jQuery.param( params );
			type = "POST";
		}
	}
	var self = this;
	jQuery.ajax( type, url, params,function(res, status){
		if ( status == "success" || !ifModified && status == "notmodified" ) {
			self.html(res.responseText).each( callback, [res.responseText, status] );
			$("script", self).each(function(){
				if ( this.src )
					$.getScript( this.src );
				else
					eval.call( window, this.text || this.textContent || this.innerHTML || "" );
			});
		} else
			callback.apply( self, [res.responseText, status] );

	}, ifModified);
	
	return this;
};
jQuery.fn.serialize = function(){
	return $.param( this );
};
if ( jQuery.browser.msie && typeof XMLHttpRequest == "undefined" )
	XMLHttpRequest = function(){
		return new ActiveXObject(
			navigator.userAgent.indexOf("MSIE 5") >= 0 ?
			"Microsoft.XMLHTTP" : "Msxml2.XMLHTTP"
		);
	};
new function(){
	var e = "ajaxStart,ajaxStop,ajaxComplete,ajaxError,ajaxSuccess".split(",");
	
	for ( var i = 0; i < e.length; i++ ) new function(){
		var o = e[i];
		jQuery.fn[o] = function(f){
			return this.bind(o, f);
		};
	};
};
jQuery.extend({

	get: function( url, data, callback, type, ifModified ) {
		if ( data.constructor == Function ) {
			type = callback;
			callback = data;
			data = null;
		}
		if ( data ) url += "?" + jQuery.param(data);
		jQuery.ajax( "GET", url, null, function(r, status) {
			if ( callback ) callback( jQuery.httpData(r,type), status );
		}, ifModified);
	},
	getIfModified: function( url, data, callback, type ) {
		jQuery.get(url, data, callback, type, 1);
	},
	getScript: function( url, data, callback ) {
		jQuery.get(url, data, callback, "script");
	},
	getJSON: function( url, data, callback ) {
		jQuery.get(url, data, callback, "json");
	},
	post: function( url, data, callback, type ) {
		jQuery.ajax( "POST", url, jQuery.param(data), function(r, status) {
			if ( callback ) callback( jQuery.httpData(r,type), status );
		});
	},
	timeout: 0,
	ajaxTimeout: function(timeout) {
		jQuery.timeout = timeout;
	},
	lastModified: {},
	ajax: function( type, url, data, ret, ifModified ) {
		if ( !url ) {
			ret = type.complete;
			var success = type.success;
			var error = type.error;
			var dataType = type.dataType;
			data = type.data;
			url = type.url;
			type = type.type;
		}
		if ( ! jQuery.active++ )
			jQuery.event.trigger( "ajaxStart" );
		var requestDone = false;
		var xml = new XMLHttpRequest();
		xml.open(type || "GET", url, true);
		if ( data )
			xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		if ( ifModified )
			xml.setRequestHeader("If-Modified-Since",
				jQuery.lastModified[url] || "Thu, 01 Jan 1970 00:00:00 GMT" );
		xml.setRequestHeader("X-Requested-With", "XMLHttpRequest");
		if ( xml.overrideMimeType )
			xml.setRequestHeader("Connection", "close");
		var onreadystatechange = function(istimeout){
			if ( xml && (xml.readyState == 4 || istimeout == "timeout") ) {
				requestDone = true;
				var status = jQuery.httpSuccess( xml ) && istimeout != "timeout" ?
					ifModified && jQuery.httpNotModified( xml, url ) ? "notmodified" : "success" : "error";
				if ( status != "error" ) {
					var modRes = xml.getResponseHeader("Last-Modified");
					if ( ifModified && modRes ) jQuery.lastModified[url] = modRes;
					if ( success )
						success( jQuery.httpData( xml, dataType ), status );
					jQuery.event.trigger( "ajaxSuccess" );
				} else {
					if ( error ) error( xml, status );
					jQuery.event.trigger( "ajaxError" );
				}
				jQuery.event.trigger( "ajaxComplete" );
				if ( ! --jQuery.active )
					jQuery.event.trigger( "ajaxStop" );
				if ( ret ) ret(xml, status);
				xml.onreadystatechange = function(){};
				xml = null;
			}
		};
		xml.onreadystatechange = onreadystatechange;
		if(jQuery.timeout > 0)
			setTimeout(function(){
				if (xml) {
					xml.abort();
					if ( !requestDone ) onreadystatechange( "timeout" );
					xml = null;
				}
			}, jQuery.timeout);
		xml.send(data);
	},
	active: 0,
	httpSuccess: function(r) {
		try {
			return !r.status && location.protocol == "file:" ||
				( r.status >= 200 && r.status < 300 ) || r.status == 304 ||
				jQuery.browser.safari && r.status == undefined;
		} catch(e){}

		return false;
	},
	httpNotModified: function(xml, url) {
		try {
			var xmlRes = xml.getResponseHeader("Last-Modified");
			return xml.status == 304 || xmlRes == jQuery.lastModified[url] ||
				jQuery.browser.safari && xml.status == undefined;
		} catch(e){}

		return false;
	},
	httpData: function(r,type) {
		var ct = r.getResponseHeader("content-type");
		var data = !type && ct && ct.indexOf("xml") >= 0;
		data = type == "xml" || data ? r.responseXML : r.responseText;
		if ( type == "script" ) eval.call( window, data );
		if ( type == "json" ) eval( "data = " + data );
		return data;
	},
	param: function(a) {
		var s = [];
		if ( a.constructor == Array || a.jquery ) {
			for ( var i = 0; i < a.length; i++ )
				s.push( a[i].name + "=" + encodeURIComponent( a[i].value ) );
		} else {
			for ( var j in a )
				s.push( j + "=" + encodeURIComponent( a[j] ) );
		}
		return s.join("&");
	}
});
