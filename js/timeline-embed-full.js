/*jslint browser: true, eqeqeq: true, bitwise: true, newcap: true, immed: true, regexp: false */
/**
LazyLoad makes it easy and painless to lazily load one or more external
JavaScript or CSS files on demand either during or after the rendering of a web
page.

Supported browsers include Firefox 2+, IE6+, Safari 3+ (including Mobile
Safari), Google Chrome, and Opera 9+. Other browsers may or may not work and
are not officially supported.

Visit https://github.com/rgrove/lazyload/ for more info.

Copyright (c) 2011 Ryan Grove <ryan@wonko.com>
All rights reserved.

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the 'Software'), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
the Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

@module lazyload
@class LazyLoad
@static
@version 2.0.3 (git)
*/
function getScriptPath(e) {
    var t = document.getElementsByTagName("script"),
        n = "",
        r = "";
    for (var i = 0; i < t.length; i++) t[i].src.match(e) && (n = t[i].src);
    n != "" && (r = "/");
    return n.split("?")[0].split("/").slice(0, - 1).join("/") + r
}
LazyLoad = function (e) {
    function u(t, n) {
        var r = e.createElement(t),
            i;
        for (i in n) n.hasOwnProperty(i) && r.setAttribute(i, n[i]);
        return r
    }
    function a(e) {
        var t = r[e],
            n, o;
        if (t) {
            n = t.callback;
            o = t.urls;
            o.shift();
            i = 0;
            if (!o.length) {
                n && n.call(t.context, t.obj);
                r[e] = null;
                s[e].length && l(e)
            }
        }
    }
    function f() {
        var n = navigator.userAgent;
        t = {
            async: e.createElement("script").async === !0
        };
        (t.webkit = /AppleWebKit\//.test(n)) || (t.ie = /MSIE/.test(n)) || (t.opera = /Opera/.test(n)) || (t.gecko = /Gecko\//.test(n)) || (t.unknown = !0)
    }
    function l(i, o, l, p, d) {
        var v = function () {
            a(i)
        }, m = i === "css",
            g = [],
            y, b, w, E, S, x;
        t || f();
        if (o) {
            o = typeof o == "string" ? [o] : o.concat();
            if (m || t.async || t.gecko || t.opera) s[i].push({
                urls: o,
                callback: l,
                obj: p,
                context: d
            });
            else for (y = 0, b = o.length; y < b; ++y) s[i].push({
                urls: [o[y]],
                callback: y === b - 1 ? l : null,
                obj: p,
                context: d
            })
        }
        if (r[i] || !(E = r[i] = s[i].shift())) return;
        n || (n = e.head || e.getElementsByTagName("head")[0]);
        S = E.urls;
        for (y = 0, b = S.length; y < b; ++y) {
            x = S[y];
            if (m) w = t.gecko ? u("style") : u("link", {
                href: x,
                rel: "stylesheet"
            });
            else {
                w = u("script", {
                    src: x
                });
                w.async = !1
            }
            w.className = "lazyload";
            w.setAttribute("charset", "utf-8");
            if (t.ie && !m) w.onreadystatechange = function () {
                if (/loaded|complete/.test(w.readyState)) {
                    w.onreadystatechange = null;
                    v()
                }
            };
            else if (m && (t.gecko || t.webkit)) if (t.webkit) {
                E.urls[y] = w.href;
                h()
            } else {
                w.innerHTML = '@import "' + x + '";';
                c(w)
            } else w.onload = w.onerror = v;
            g.push(w)
        }
        for (y = 0, b = g.length; y < b; ++y) n.appendChild(g[y])
    }
    function c(e) {
        var t;
        try {
            t = !! e.sheet.cssRules
        } catch (n) {
            i += 1;
            i < 200 ? setTimeout(function () {
                c(e)
            }, 50) : t && a("css");
            return
        }
        a("css")
    }
    function h() {
        var e = r.css,
            t;
        if (e) {
            t = o.length;
            while (--t >= 0) if (o[t].href === e.urls[0]) {
                a("css");
                break
            }
            i += 1;
            e && (i < 200 ? setTimeout(h, 50) : a("css"))
        }
    }
    var t, n, r = {}, i = 0,
        s = {
            css: [],
            js: []
        }, o = e.styleSheets;
    return {
        css: function (e, t, n, r) {
            l("css", e, t, n, r)
        },
        js: function (e, t, n, r) {
            l("js", e, t, n, r)
        }
    }
}(this.document);
var WebFontConfig;
if (typeof embed_path == "undefined" || typeof embed_path == "undefined") var embed_path = getScriptPath("timeline-embed-full.js").split("js/")[0];

alert(embed_path);
(function () {
    function v() {
        LazyLoad.js(l.js, m)
    }
    function m() {
        a.js = !0;
        l.lang != "en" ? LazyLoad.js(f.locale, g) : a.language = !0;
        E()
    }
    function g() {
        a.language = !0;
        E()
    }
    function y() {
        a.css = !0;
        E()
    }
    function b() {
        a.font.css = !0;
        E()
    }
    function w() {
        a.font.js = !0;
        E()
    }
    function E() {
        if (a.checks > 40) return;
        a.checks++;
        if (a.js && a.css && a.font.css && a.font.js && a.language) {
            if (!a.finished) {
                a.finished = !0;
                x()
            }
        } else a.timeout = setTimeout("onloaded_check_again();", 250)
    }
    function S() {
        t = document.createElement("div");
        n = document.getElementById("timeline-embed");
        n.appendChild(t);
        t.setAttribute("id", "timelinejs");
        if (l.width.toString().match("%")) {
            n.style.width = l.width;
            n.setAttribute("class", "full-embed ");
            n.setAttribute("className", "full-embed ")
        } else {
            n.setAttribute("class", " sized-embed");
            n.setAttribute("className", " sized-embed");
            l.width = l.width - 2;
            n.style.width = l.width + "px"
        }
        if (l.height.toString().match("%")) n.style.height = l.height;
        else {
            l.height = l.height - 16;
            n.style.height = l.height + "px"
        }
        t.style.position = "relative"
    }
    function x() {
        VMM.debug = l.debug;
        e = new VMM.Timeline;
        e.init(l.source);
        i && VMM.bindEvent(global, onHeadline, "HEADLINE")
    }
    var e, t, n, r, i = !1,
        s = "1.68",
        o = "1.7.1",
        u = "",
        a = {
            timeout: "",
            checks: 0,
            finished: !1,
            js: !1,
            css: !1,
            jquery: !1,
            has_jquery: !1,
            language: !1,
            font: {
                css: !1,
                js: !1
            }
        }, f = {
           base: embed_path,
            css: embed_path + "css/",
            js: embed_path + "js/",
            locale: embed_path + "js/locale/",
            jquery: "http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js",
            font: {
                google: !1,
                css: embed_path + "css/themes/font/",
                js: "http://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js"
            }
        }, l = {
            version: s,
            debug: !1,
            embed: !0,
            width: "100%",
            height: "650",
            source: "https://docs.google.com/spreadsheet/pub?key=0Agl_Dv6iEbDadFYzRjJPUGktY0NkWXFUWkVIZDNGRHc&output=html",
            lang: "en",
            font: "default",
            css: f.css + "timeline.css?" + s,
            js: f.js + "timeline-min.js?" + s
        }, c = [{
            name: "Merriweather-NewsCycle",
            google: ["News+Cycle:400,700:latin", "Merriweather:400,700,900:latin"]
        }, {
            name: "PoiretOne-Molengo",
            google: ["Poiret+One::latin", "Molengo::latin"]
        }, {
            name: "Arvo-PTSans",
            google: ["Arvo:400,700,400italic:latin", "PT+Sans:400,700,400italic:latin"]
        }, {
            name: "PTSerif-PTSans",
            google: ["PT+Sans:400,700,400italic:latin", "PT+Serif:400,700,400italic:latin"]
        }, {
            name: "PT",
            google: ["PT+Sans+Narrow:400,700:latin", "PT+Sans:400,700,400italic:latin", "PT+Serif:400,700,400italic:latin"]
        }, {
            name: "DroidSerif-DroidSans",
            google: ["Droid+Sans:400,700:latin", "Droid+Serif:400,700,400italic:latin"]
        }, {
            name: "Lekton-Molengo",
            google: ["Lekton:400,700,400italic:latin", "Molengo::latin"]
        }, {
            name: "NixieOne-Ledger",
            google: ["Nixie+One::latin", "Ledger::latin"]
        }, {
            name: "AbrilFatface-Average",
            google: ["Average::latin", "Abril+Fatface::latin"]
        }, {
            name: "PlayfairDisplay-Muli",
            google: ["Playfair+Display:400,400italic:latin", "Muli:300,400,300italic,400italic:latin"]
        }, {
            name: "Rancho-Gudea",
            google: ["Rancho::latin", "Gudea:400,700,400italic:latin"]
        }, {
            name: "Bevan-PotanoSans",
            google: ["Bevan::latin", "Pontano+Sans::latin"]
        }, {
            name: "BreeSerif-OpenSans",
            google: ["Bree+Serif::latin", "Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800:latin"]
        }, {
            name: "SansitaOne-Kameron",
            google: ["Sansita+One::latin", "Kameron:400,700:latin"]
        }, {
            name: "Lora-Istok",
            google: ["Lora:400,700,400italic,700italic:latin", "Istok+Web:400,700,400italic,700italic:latin"]
        }, {
            name: "Pacifico-Arimo",
            google: ["Pacifico::latin", "Arimo:400,700,400italic,700italic:latin"]
        }];
    if (typeof url_config == "object") {
        l.height = "100%";
        
        for (r in url_config) Object.prototype.hasOwnProperty.call(url_config, r) && (l[r] = url_config[r]);
        l.source.match("docs.google.com") || l.source.match("json") || l.source.match("storify") || (l.source = "https://docs.google.com/spreadsheet/pub?key=" + l.source + "&output=html");
        i = !0
    } else if (typeof timeline_config == "object") for (r in timeline_config) Object.prototype.hasOwnProperty.call(timeline_config, r) && (l[r] = timeline_config[r]);
    else if (typeof config == "object") for (r in config) Object.prototype.hasOwnProperty.call(config, r) && (l[r] = config[r]);
    l.lang.match("/") ? f.locale = l.lang : f.locale = f.locale + l.lang + ".js?" + s;
    if (l.js.match("locale")) {
        l.lang = l.js.split("locale/")[1].replace(".js", "");
        l.js = f.js + "timeline-min.js?" + s
    }
    S();
    LazyLoad.css(l.css, y);
    if (l.font == "default") {
        a.font.js = !0;
        a.font.css = !0
    } else {
        var h;
        if (l.font.match("/")) {
            h = l.font.split(".css")[0].split("/");
            f.font.name = h[h.length - 1];
            f.font.css = l.font
        } else {
            f.font.name = l.font;
            f.font.css = f.font.css + l.font + ".css?" + s
        }
        LazyLoad.css(f.font.css, b);
        for (var p = 0; p < c.length; p++) if (f.font.name == c[p].name) {
            f.font.google = !0;
            WebFontConfig = {
                google: {
                    families: c[p].google
                }
            }
        }
        f.font.google ? LazyLoad.js(f.font.js, w) : a.font.js = !0
    }
    try {
        a.has_jquery = jQuery;
        a.has_jquery = !0;
        if (a.has_jquery) {
            var u = parseFloat(jQuery.fn.jquery);
            u < parseFloat(o) ? a.jquery = !1 : a.jquery = !0
        }
    } catch (d) {
        a.jquery = !1
    }
    a.jquery ? v() : LazyLoad.js(f.jquery, v);
    this.onloaded_check_again = function () {
        E()
    }
})();