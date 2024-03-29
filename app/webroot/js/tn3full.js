(function (f) {
    function e(h) {
        var j = h.skinDir + "/" + h.skin,
            l = n[j];
        if (l) l.loaded ? a.call(this, h, l.html) : l.queue.push({
            c: this,
            s: h
        });
        else {
            n[j] = {
                loaded: false,
                queue: [{
                    c: this,
                    s: h
                }]
            };
            f.ajax({
                url: j + ".html",
                dataType: "text",
                success: function (m) {
                    var p = n[j];
                    p.loaded = true;
                    p.html = m;
                    for (m = 0; m < p.queue.length; m++) a.call(p.queue[m].c, p.queue[m].s, p.html)
                },
                dataFilter: function (m) {
                    return m = m.substring(m.indexOf("<body>") + 6, m.lastIndexOf("</body>"))
                },
                error: function () {
                    if (h.error) {
                        var m = f.Event("tn3_error");
                        m.description = "tn3 skin load error";
                        h.error(m)
                    }
                }
            })
        }
        return this
    }
    function a(h, j) {
        this.each(function () {
            for (var l = f(this), m, p, q = j.indexOf("<img src="); q != -1;) {
                q += 10;
                p = j.indexOf('"', q);
                m = h.skinDir + "/" + j.substring(q, p);
                j = j.substr(0, q) + m + j.substr(p);
                q = j.indexOf("<img src=", q)
            }
            l.append(j);
            l.data("tn3").init(l, h.fullOnly)
        })
    }
    function c(h) {
        var j = [],
            l = h.children(".tn3.album"),
            m, p;
        if (l.length > 0) l.each(function (q) {
            m = f(this);
            j[q] = {
                title: m.find(":header").html()
            };
            f.extend(j[q], b(m));
            if (p = d(m)) {
                j[q].imgs = p;
                if (!j[q].thumb) j[q].thumb = j[q].imgs[0].thumb
            }
        });
        else if (p = d(h)) j[0] = {
            imgs: p
        };
        return j
    }
    function d(h) {
        var j = [],
            l, m, p;
        l = h.find("li");
        if (l.length > 0) l.each(function (q) {
            m = f(this);
            p = m.find(":header");
            j[q] = {
                title: p.html(),
                img: m.find("a").attr("href"),
                thumb: m.find("a img").attr("src")
            };
            if (!j[q].img) j[q].img = m.find("img").attr("src");
            f.extend(j[q], b(m))
        });
        else {
            l = h.find("img");
            l.each(function (q) {
                m = f(this);
                $at = m.parent("a");
                j[q] = $at.length == 0 ? {
                    title: m.attr("title"),
                    img: m.attr("src")
                } : {
                    title: m.attr("title"),
                    img: $at.attr("href"),
                    thumb: m.attr("src")
                }
            })
        }
        if (j.length == 0) return null;
        return j
    }
    function b(h) {
        var j = {};
        h = h.children(".tn3");
        var l;
        f.each(h, function () {
            l = f(this);
            j[l.attr("class").substr(4)] = l.html()
        });
        return j
    }
    function g(h) {
        f('a[href^="#tn3-' + h + '"]').click(function (j) {
            var l = k[h];
            j = f(j.currentTarget).attr("href");
            j = j.substr(j.indexOf("-", 5) + 1);
            j = j.split("-");
            switch (j[0]) {
            case "next":
                l.cAlbum != null && l.show("next", j[1] == "fs");
                break;
            case "prev":
                l.cAlbum != null && l.show("prev", j[1] == "fs");
                break;
            default:
                l.cAlbum != parseInt(j[0]) ? l.showAlbum(parseInt(j[0]), parseInt(j[1]), j[2] == "fs") : l.show(parseInt(j[1]), j[2] == "fs")
            }
        })
    }
    function i() {
        if (k.length == 0) {
            var h = f(".tn3gallery");
            h.length > 0 && h.tn3({})
        }
    }
    if (/1\.(0|1|2|3|4)\.(0|1)/.test(f.fn.jquery) || /^1.1/.test(f.fn.jquery) || /^1.2/.test(f.fn.jquery) || /^1.3/.test(f.fn.jquery)) alert("tn3gallery requires jQuery v1.4.2 or later!  You are using v" + f.fn.jquery);
    else {
        var n = {},
            k = [];
        f.fn.tn3 = function (h) {
            f.each(["skin", "startWithAlbums", "external"], function (l, m) {
                var p = m.split(".");
                if (p.length > 1 && h[p[0]]) delete h[p[0]][p[1]];
                else delete h[m]
            });
            h = f.extend(true, {}, f.fn.tn3.config, h);
            if (h.skin != null) if (typeof h.skin == "object") {
                h.skinDir += "/" + h.skin[0];
                if (h.cssID == null) h.cssID = h.skin[0];
                h.skin = h.skin[1]
            } else h.skinDir += "/" + h.skin;
            else {
                h.skin = "tn3";
                h.skinDir += "/tn3";
                var j = true
            }
            if (h.cssID == null) h.cssID = h.skin == null ? "tn3" : h.skin;
            this.each(function () {
                var l = f(this);
                h.fullOnly ? l.hide() : l.css("visibility", "hidden");
                var m = h.data ? h.data : c(l);
                m = k.push(new f.fn.tn3.Gallery(m, h)) - 1;
                l.data("tn3", k[m]);
                for (var p = 0; p < f.fn.tn3.plugins.length; p++) f.fn.tn3.plugins[p].init(l, h);
                l.empty();
                g(m)
            });
            j ? a.call(this, h, h.skinDefault) : e.call(this, h);
            return this
        };
        f.fn.tn3.plugins = [];
        f.fn.tn3.plugIn = function (h, j) {
            f.fn.tn3.plugins.push({
                id: h,
                init: j
            })
        };
        f.fn.tn3.version = "1.1.0.30";
        f.fn.tn3.config = {
            data: null,
            skin: null,
            skinDir: "skins",
            skinDefault: '<div class="tn3-gallery"><div class="tn3-image"><div class="tn3-next tn3_v tn3_o"></div><div class="tn3-prev tn3_v tn3_o"></div><div class="tn3-preloader tn3_h tn3_v"><img src="preload.gif"/></div><div class="tn3-timer"></div></div><div class="tn3-controls-bg tn3_rh"><div class="tn3-sep1"></div><div class="tn3-sep3"></div></div><div class="tn3-thumbs"></div><div class="tn3-fullscreen"></div><div class="tn3-show-albums"></div><div class="tn3-next-page"></div><div class="tn3-prev-page"></div><div class="tn3-play"></div><div class="tn3-count"></div><div class="tn3-albums"><div class="tn3-inalbums"><div class="tn3-album"></div></div><div class="tn3-albums-next"></div><div class="tn3-albums-prev"></div><div class="tn3-albums-close"></div></div></div>',
            cssID: null
        };
        f.fn.tn3.translations = {};
        f.fn.tn3.translate = function (h, j) {
            if (j) f.fn.tn3.translations[h] = j;
            else {
                var l = f.fn.tn3.translations[h];
                return l ? l : h
            }
        };
        f(function () {
            setTimeout(i, 1)
        })
    }
})(jQuery);
(function (f) {
    f.fn.tn3utils = U = {};
    U.shuffle = function (e) {
        var a, c, d = e.length;
        if (d) for (; --d;) {
            c = Math.floor(Math.random() * (d + 1));
            a = e[c];
            e[c] = e[d];
            e[d] = a
        }
    };
    f.extend(f.easing, {
        def: "easeOutQuad",
        swing: function (e, a, c, d, b) {
            return f.easing[f.easing.def](e, a, c, d, b)
        },
        linear: function (e, a, c, d, b) {
            return d * a / b + c
        },
        easeInQuad: function (e, a, c, d, b) {
            return d * (a /= b) * a + c
        },
        easeOutQuad: function (e, a, c, d, b) {
            return -d * (a /= b) * (a - 2) + c
        },
        easeInOutQuad: function (e, a, c, d, b) {
            if ((a /= b / 2) < 1) return d / 2 * a * a + c;
            return -d / 2 * (--a * (a - 2) - 1) + c
        },
        easeInCubic: function (e, a, c, d, b) {
            return d * (a /= b) * a * a + c
        },
        easeOutCubic: function (e, a, c, d, b) {
            return d * ((a = a / b - 1) * a * a + 1) + c
        },
        easeInOutCubic: function (e, a, c, d, b) {
            if ((a /= b / 2) < 1) return d / 2 * a * a * a + c;
            return d / 2 * ((a -= 2) * a * a + 2) + c
        },
        easeInQuart: function (e, a, c, d, b) {
            return d * (a /= b) * a * a * a + c
        },
        easeOutQuart: function (e, a, c, d, b) {
            return -d * ((a = a / b - 1) * a * a * a - 1) + c
        },
        easeInOutQuart: function (e, a, c, d, b) {
            if ((a /= b / 2) < 1) return d / 2 * a * a * a * a + c;
            return -d / 2 * ((a -= 2) * a * a * a - 2) + c
        },
        easeInQuint: function (e, a, c, d, b) {
            return d * (a /= b) * a * a * a * a + c
        },
        easeOutQuint: function (e, a, c, d, b) {
            return d * ((a = a / b - 1) * a * a * a * a + 1) + c
        },
        easeInOutQuint: function (e, a, c, d, b) {
            if ((a /= b / 2) < 1) return d / 2 * a * a * a * a * a + c;
            return d / 2 * ((a -= 2) * a * a * a * a + 2) + c
        },
        easeInSine: function (e, a, c, d, b) {
            return -d * Math.cos(a / b * (Math.PI / 2)) + d + c
        },
        easeOutSine: function (e, a, c, d, b) {
            return d * Math.sin(a / b * (Math.PI / 2)) + c
        },
        easeInOutSine: function (e, a, c, d, b) {
            return -d / 2 * (Math.cos(Math.PI * a / b) - 1) + c
        },
        easeInExpo: function (e, a, c, d, b) {
            return a == 0 ? c : d * Math.pow(2, 10 * (a / b - 1)) + c
        },
        easeOutExpo: function (e, a, c, d, b) {
            return a == b ? c + d : d * (-Math.pow(2, -10 * a / b) + 1) + c
        },
        easeInOutExpo: function (e, a, c, d, b) {
            if (a == 0) return c;
            if (a == b) return c + d;
            if ((a /= b / 2) < 1) return d / 2 * Math.pow(2, 10 * (a - 1)) + c;
            return d / 2 * (-Math.pow(2, -10 * --a) + 2) + c
        },
        easeInCirc: function (e, a, c, d, b) {
            return -d * (Math.sqrt(1 - (a /= b) * a) - 1) + c
        },
        easeOutCirc: function (e, a, c, d, b) {
            return d * Math.sqrt(1 - (a = a / b - 1) * a) + c
        },
        easeInOutCirc: function (e, a, c, d, b) {
            if ((a /= b / 2) < 1) return -d / 2 * (Math.sqrt(1 - a * a) - 1) + c;
            return d / 2 * (Math.sqrt(1 - (a -= 2) * a) + 1) + c
        },
        easeInElastic: function (e, a, c, d, b) {
            e = 1.70158;
            var g = 0,
                i = d;
            if (a == 0) return c;
            if ((a /= b) == 1) return c + d;
            g || (g = b * 0.3);
            if (i < Math.abs(d)) {
                i = d;
                e = g / 4
            } else e = g / (2 * Math.PI) * Math.asin(d / i);
            return -(i * Math.pow(2, 10 * (a -= 1)) * Math.sin((a * b - e) * 2 * Math.PI / g)) + c
        },
        easeOutElastic: function (e, a, c, d, b) {
            e = 1.70158;
            var g = 0,
                i = d;
            if (a == 0) return c;
            if ((a /= b) == 1) return c + d;
            g || (g = b * 0.3);
            if (i < Math.abs(d)) {
                i = d;
                e = g / 4
            } else e = g / (2 * Math.PI) * Math.asin(d / i);
            return i * Math.pow(2, -10 * a) * Math.sin((a * b - e) * 2 * Math.PI / g) + d + c
        },
        easeInOutElastic: function (e, a, c, d, b) {
            e = 1.70158;
            var g = 0,
                i = d;
            if (a == 0) return c;
            if ((a /= b / 2) == 2) return c + d;
            g || (g = b * 0.3 * 1.5);
            if (i < Math.abs(d)) {
                i = d;
                e = g / 4
            } else e = g / (2 * Math.PI) * Math.asin(d / i);
            if (a < 1) return -0.5 * i * Math.pow(2, 10 * (a -= 1)) * Math.sin((a * b - e) * 2 * Math.PI / g) + c;
            return i * Math.pow(2, -10 * (a -= 1)) * Math.sin((a * b - e) * 2 * Math.PI / g) * 0.5 + d + c
        },
        easeInBack: function (e, a, c, d, b, g) {
            if (g == undefined) g = 1.70158;
            return d * (a /= b) * a * ((g + 1) * a - g) + c
        },
        easeOutBack: function (e, a, c, d, b, g) {
            if (g == undefined) g = 1.70158;
            return d * ((a = a / b - 1) * a * ((g + 1) * a + g) + 1) + c
        },
        easeInOutBack: function (e, a, c, d, b, g) {
            if (g == undefined) g = 1.70158;
            if ((a /= b / 2) < 1) return d / 2 * a * a * (((g *= 1.525) + 1) * a - g) + c;
            return d / 2 * ((a -= 2) * a * (((g *= 1.525) + 1) * a + g) + 2) + c
        },
        easeInBounce: function (e, a, c, d, b) {
            return d - f.easing.easeOutBounce(e, b - a, 0, d, b) + c
        },
        easeOutBounce: function (e, a, c, d, b) {
            return (a /= b) < 1 / 2.75 ? d * 7.5625 * a * a + c : a < 2 / 2.75 ? d * (7.5625 * (a -= 1.5 / 2.75) * a + 0.75) + c : a < 2.5 / 2.75 ? d * (7.5625 * (a -= 2.25 / 2.75) * a + 0.9375) + c : d * (7.5625 * (a -= 2.625 / 2.75) * a + 0.984375) + c
        },
        easeInOutBounce: function (e, a, c, d, b) {
            if (a < b / 2) return f.easing.easeInBounce(e, a * 2, 0, d, b) * 0.5 + c;
            return f.easing.easeOutBounce(e, a * 2 - b, 0, d, b) * 0.5 + d * 0.5 + c
        }
    })
})(jQuery);
(function (f) {
    f.fn.tn3.Gallery = function (a, c) {
        this.data = a;
        this.config = f.extend(true, {}, f.fn.tn3.Gallery.config, c);
        this.initialized = false;
        this.t = f.fn.tn3.translate;
        this.loader = new f.fn.tn3.External(c.external, this)
    };
    f.fn.tn3.Gallery.config = {
        cssID: "tn3",
        active: [],
        iniAlbum: 0,
        iniImage: 0,
        imageClick: "next",
        startWithAlbums: false,
        autoplay: false,
        delay: 7E3,
        timerMode: "bar",
        timerSteps: 500,
        timerStepChar: "&#8226;",
        isFullScreen: false,
        fullOnly: false,
        width: null,
        height: null,
        mouseWheel: true,
        image: {},
        thumbnailer: {}
    };
    var e;
    f.fn.tn3.Gallery.prototype = {
        config: null,
        $c: null,
        $tn3: null,
        data: null,
        thumbnailer: null,
        imager: null,
        cAlbum: null,
        timer: null,
        items: null,
        initialized: null,
        n: null,
        albums: null,
        loader: null,
        fso: null,
        timerSize: null,
        special: null,
        areHidden: false,
        $inImage: null,
        init: function (a, c) {
            this.$c = a;
            if (!(this.loader.reqs > 0 || this.data.length == 0 || c)) {
                this.trigger("init_start");
                this.config.fullOnly && this.$c.show();
                this.$c.css("visibility", "visible");
                this.$tn3 = this.$c.find("." + this.config.cssID + "-gallery");
                var d = this.config.initValues = {
                    width: this.$tn3.width(),
                    height: this.$tn3.height()
                };
                this.$tn3.css("float", "left");
                d.wDif = this.$tn3.outerWidth(true) - d.width;
                d.hDif = this.$tn3.outerHeight(true) - d.height;
                this.replaceMenu("", "");
                var b = this;
                this.timer = new f.fn.tn3.Timer(this.$c, this.config.delay, this.config.timerSteps);
                this.$c.bind("timer_end", function () {
                    b.show("next")
                });
                this.special = {
                    rv: [],
                    rh: [],
                    v: [],
                    h: [],
                    o: []
                };
                this.parseLayout();
                this.center();
                f.each(this.items, function (g, i) {
                    switch (g) {
                    case "next":
                        i.click(function (k) {
                            b.show("next");
                            k.stopPropagation()
                        });
                        i.attr("title", b.t("Next Image"));
                        break;
                    case "prev":
                        i.click(function (k) {
                            b.show("prev");
                            k.stopPropagation()
                        });
                        i.attr("title", b.t("Previous Image"));
                        break;
                    case "next-page":
                        i.click(function () {
                            b.items.thumbs && b.thumbnailer.next(true)
                        });
                        i.attr("title", b.t("Next Page"));
                        break;
                    case "prev-page":
                        i.click(function () {
                            b.items.thumbs && b.thumbnailer.prev(true)
                        });
                        i.attr("title", b.t("Previous Page"));
                        break;
                    case "thumbs":
                        b.config.thumbnailer.cssID = b.config.cssID;
                        b.config.thumbnailer.initValues = {
                            width: i.width(),
                            height: i.height()
                        };
                        b.config.thumbnailer.initValues.vertical = i.width() <= i.height();
                        i.bind("tn_click", function (k) {
                            b.show(k.n)
                        }).bind("tn_over", function () {
                            b.timer.pause(true)
                        }).bind("tn_out", function () {
                            b.timer.pause(false)
                        }).bind("tn_error", function (k) {
                            b.trigger("error", k)
                        });
                        break;
                    case "image":
                        b.config.image.cssID = b.config.cssID;
                        b.config.image.initValues = {
                            width: i.width(),
                            height: i.height()
                        };
                        i.bind("img_click", function (k) {
                            switch (b.config.imageClick) {
                            case "next":
                                b.show("next");
                                break;
                            case "fullscreen":
                                b.fullscreen();
                                break;
                            case "url":
                                if (k = b.data[b.cAlbum].imgs[k.n].url) window.location = k
                            }
                        }).bind("img_load_start", function () {
                            b.items.preloader && b.items.preloader.show()
                        }).bind("img_load_end", function (k) {
                            b.n = k.n;
                            b.items.thumbs && b.thumbnailer.thumbClick(k.n);
                            b.items.preloader && b.items.preloader.hide();
                            b.items.timer && b.items.timer.hide();
                            b.$inImage && b.$inImage.hide()
                        }).bind("img_transition", function () {
                            b.setTextValues(false, "image");
                            b.$inImage && b.$inImage.fadeIn(300);
                            b.items.count && b.items.count.text(b.n + 1 + "/" + b.data[b.cAlbum].imgs.length);
                            b.config.autoplay && b.timer.start();
                            b.special.o.length > 0 && b.hideElements()
                        }).bind("img_enter", function () {
                            b.items.timer && b.timer.pause(true);
                            b.special.o.length > 0 && b.showElements(300)
                        }).bind("img_leave", function () {
                            b.items.timer && b.timer.pause(false);
                            b.special.o.length > 0 && b.hideElements(300)
                        }).bind("img_resize", function (k) {
                            if (b.$inImage) {
                                b.$inImage.width(k.w).height(k.h).css("left", k.left).css("top", k.top);
                                b.center();
                                b.imager.bindMouseEvents(b.$inImage)
                            }
                        }).bind("img_error", function (k) {
                            b.trigger("error", k)
                        });
                        break;
                    case "preloader":
                        i.hide();
                        break;
                    case "timer":
                        var n = i.width() > i.height() ? "width" : "height";
                        b.$c.bind("timer_tick", function (k) {
                            if (b.config.timerMode == "char") {
                                for (var h = b.config.timerStepChar; --k.tick;) h += b.config.timerStepChar;
                                b.items.timer.html(h)
                            } else b.items.timer[n](b.timerSize / k.totalTicks * k.tick);
                            b.trigger(k.type, k)
                        }).bind("timer_start", function (k) {
                            b.timerSize = b.$inImage[n]();
                            b.items.timer.fadeIn(300);
                            b.trigger(k.type, k)
                        }).bind("timer_end timer_stop", function () {
                            b.items.timer.hide()
                        });
                        i.hide();
                        break;
                    case "play":
                        i.click(function (k) {
                            if (b.timer.runs) {
                                b.timer.stop();
                                b.config.autoplay = false;
                                i.removeClass(b.config.cssID + "-play-active");
                                i.attr("title", b.t("Start Slideshow"))
                            } else {
                                b.timer.start();
                                b.config.autoplay = true;
                                i.addClass(b.config.cssID + "-play-active");
                                i.attr("title", b.t("Stop Slideshow"))
                            }
                            k.stopPropagation()
                        });
                        i.attr("title", b.t("Start Slideshow"));
                        b.config.autoplay && i.click();
                        break;
                    case "albums":
                        b.albums = new f.fn.tn3.Albums(b.data, i, b.config.cssID);
                        i.hide();
                        i.bind("albums_binit", function (k) {
                            b.trigger(k.type, k)
                        }).bind("albums_click", function (k) {
                            b.showAlbum(k.n);
                            b.trigger(k.type, k)
                        }).bind("albums_init", function (k) {
                            b.timer.pause(true);
                            b.trigger(k.type, k)
                        }).bind("albums_error", function (k) {
                            b.trigger("error", k)
                        }).bind("albums_close", function () {
                            b.timer.pause(false)
                        });
                        break;
                    case "albums-next":
                        b.albums && b.albums.setControl("next", i);
                        i.attr("title", b.t("Next Album Page"));
                        break;
                    case "albums-prev":
                        b.albums && b.albums.setControl("prev", i);
                        i.attr("title", b.t("Previous Album Page"));
                        break;
                    case "albums-close":
                        b.albums && b.albums.setControl("close", i);
                        i.attr("title", b.t("Close"));
                        break;
                    case "show-albums":
                        i.click(function (k) {
                            b.items.albums && b.albums.show(0, b.cAlbum, false, true);
                            k.stopPropagation()
                        });
                        i.attr("title", b.t("Album List"));
                        break;
                    case "fullscreen":
                        i.click(function (k) {
                            b.fullscreen();
                            k.stopPropagation()
                        });
                        i.attr("title", b.t("Maximize"))
                    }
                });
                if (this.config.width !== null || this.config.height !== null) {
                    if (this.config.width == null) this.config.width = this.config.initValues.width;
                    if (this.config.height == null) this.config.height = this.config.initValues.height;
                    this.resize(this.config.width, this.config.height)
                }
                d = Math.min(this.config.iniAlbum, this.data.length - 1);
                this.initialized = true;
                this.config.startWithAlbums && this.data.length > 1 && this.items.albums ? this.albums.show() : this.showAlbum(d, this.config.iniImage);
                this.config.isFullScreen && this.onFullResize(f(window).width(), f(window).height());
                this.trigger("init")
            }
        },
        parseLayout: function () {
            var a = this.items = {},
                c = this.config,
                d = c.active,
                b = c.cssID.length + 1,
                g = this,
                i, n;
            this.$c.find("div[class^='" + c.cssID + "-']").each(function () {
                i = f(this);
                n = i.attr("class").split(" ")[0].substr(b);
                if (d.length == 0 || f.inArray(n, d) != -1) a[n] = i;
                else n != "gallery" && i.remove();
                if (i.parent().hasClass(c.cssID + "-image")) {
                    if (!g.$inImage) {
                        g.$inImage = i.parent().append('<div class="tn3-in-image"></div>').find(":last");
                        if (f.browser.msie) {
                            var h = f("<div />");
                            h.css("background-color", "#fff").css("opacity", 0).css("width", "100%").css("height", "100%");
                            h.appendTo(g.$inImage)
                        }
                        g.$inImage.css("position", "absolute").width(a.image.width()).height(a.image.height())
                    }
                    i.appendTo(g.$inImage)
                }
                this.className.indexOf("tn3_") != -1 && g.addSpecial(n, this.className)
            });
            $cm = this.$c;
            f.each(["albums", "album", "album-next", "album-prev", "show-albums", "timer"], function (h, j) {
                delete a[j];
                $cm.find("." + c.cssID + "-" + j).remove()
            });
            var k = f('');
            k.css("position", "absolute").css("background-image", "url('" + this.config.skinDir + "/tn3.png')").css("background-position", "-258px -7px").css("bottom", "14px").css("right", "53px").css("cursor", "pointer").width(40).height(18);
            k.appendTo(this.$c.find("." + c.cssID + "-gallery"));
            k.click(function () {
                window.location = "http://tn3gallery.com"
            }).hover(function () {
                f(this).css("background-position", "-258px -45px")
            }, function () {
                f(this).css("background-position", "-258px -7px")
            })
        },
        addSpecial: function (a, c) {
            for (var d = c.split(" "), b, g = 0; g < d.length; g++) {
                b = d[g].split("_");
                if (b[0] == "tn3") {
                    this.special[b[1]].push(a);
                    if (b[1] == "rh" || b[1] == "rv") this.config.initValues[a] = {
                        w: this.items[a].width(),
                        h: this.items[a].height()
                    }
                }
            }
        },
        initHover: function (a, c) {
            var d = this;
            a.hover(function () {
                a.addClass(d.config.cssID + "-" + c + "-over")
            }, function () {
                a.removeClass(d.config.cssID + "-" + c + "-over")
            })
        },
        setTextValues: function (a, c) {
            var d, b, g, i = c + "-";
            for (g in this.items) if (g.indexOf(i) == 0) {
                d = g.substr(i.length);
                if (d != "info" && d != "prev" && d != "next") {
                    b = c == "image" ? this.data[this.cAlbum].imgs[this.n] : this.data[this.cAlbum];
                    if (!(!b || b[d] == undefined)) {
                        b[d] = f.trim(b[d]);
                        d = {
                            field: d,
                            text: b[d],
                            data: b
                        };
                        this.trigger("set_text", d);
                        if (a || d.text == undefined || d.text.length == 0) {
                            this.items[g].html("");
                            this.items[g].hide()
                        } else {
                            this.items[g].html(d.text);
                            this.items[g].show()
                        }
                    }
                }
            }
        },
        show: function (a, c) {
            this.timer.stop();
            this.imager && this.imager.show(a);
            c && this.fullscreen()
        },
        setAlbumData: function (a, c) {
            if (c) this.trigger("error", {
                description: c
            });
            else {
                for (var d = 0, b = a.length; d < b; d++) this.data.push(a[d]);
                this.$c && this.init(this.$c, this.config.fullOnly)
            }
        },
        setImageData: function (a, c, d) {
            if (d) this.trigger("error", {
                description: d
            });
            else {
                a = {
                    data: a
                };
                this.trigger("image_data", a);
                this.data[c].imgs = a.data;
                this.cAlbum == c && this.rebuild(a.data)
            }
        },
        showAlbum: function (a, c, d) {
            if (this.initialized) {
                if (a > this.data.length) return;
                this.timer.stop();
                this.cAlbum = a;
                if (this.data[this.cAlbum].imgs === undefined) this.loader ? this.loader.getImages(this.data[this.cAlbum].adata, this.cAlbum) : this.trigger("error", {
                    description: "Wrong album id"
                });
                else this.rebuild(this.data[this.cAlbum].imgs, c);
                this.albums && this.albums.hide();
                this.items.preloader && this.items.preloader.show()
            } else {
                this.config.iniAlbum = a;
                this.config.iniImage = c;
                this.init(this.$c, false)
            }
            d && this.fullscreen()
        },
        rebuild: function (a, c) {
            if (this.items.thumbs) if (this.thumbnailer) this.thumbnailer.rebuild(a);
            else this.thumbnailer = new f.fn.tn3.Thumbnailer(this.items.thumbs, a, this.config.thumbnailer);
            if (this.items.image) if (this.imager) this.imager.rebuild(a);
            else this.imager = new f.fn.tn3.Imager(this.items.image, a, this.config.image);
            this.setTextValues(true, "image");
            this.setTextValues(false, "album");
            this.show(c == null ? 0 : c);
            this.trigger("rebuild", {
                album: this.cAlbum
            })
        },
        showElements: function (a) {
            if (this.areHidden) {
                var c = this,
                    d;
                f.each(this.special.o, function (b, g) {
                    d = c.items[g];
                    d.show();
                    if (a && f.support.opacity) {
                        d.stop(true);
                        d.css("opacity", 0);
                        d.animate({
                            opacity: 1
                        }, {
                            duration: a,
                            queue: false
                        })
                    }
                });
                this.areHidden = false
            }
        },
        hideElements: function (a) {
            if (!this.areHidden) {
                var c = this,
                    d;
                f.each(this.special.o, function (b, g) {
                    d = c.items[g];
                    if (a && f.support.opacity) {
                        d.stop(true);
                        d.animate({
                            opacity: 0
                        }, {
                            duration: a,
                            complete: function () {
                                d.hide()
                            },
                            queue: false
                        })
                    } else d.hide()
                });
                this.areHidden = true
            }
        },
        setData: function (a) {
            if (this.items.thumbs) this.thumbnailer.data = a;
            if (this.items.imager) this.imager.data = a
        },
        fullscreen: function () {
            if (this.config.isFullScreen) {
                f(window).unbind("resize", this.onFullResize);
                f.tn3unblock();
                this.config.width !== null || this.config.height !== null ? this.resize(this.config.width, this.config.height) : this.resize(this.config.initValues.width, this.config.initValues.height);
                if (this.items.fullscreen) {
                    this.items.fullscreen.removeClass(this.config.cssID + "-fullscreen-active");
                    this.items.fullscreen.attr("title", this.t("Maximize"))
                }
                this.config.fullOnly && this.$c.hide();
                this.config.isFullScreen = false;
                this.trigger("fullscreen", {
                    fullscreen: false
                });
                f(document).unbind("keyup", this.onEscape)
            } else {
                f.tn3block({
                    message: this.$tn3,
                    cssID: this.config.cssID
                });
                f(window).bind("resize", f.proxy(this.onFullResize, this));
                this.config.fullOnly && this.$c.show();
                this.config.isFullScreen = true;
                if (this.items.fullscreen) {
                    this.items.fullscreen.addClass(this.config.cssID + "-fullscreen-active");
                    this.items.fullscreen.attr("title", this.t("Minimize"))
                }
                this.onFullResize();
                e = this;
                this.trigger("fullscreen", {
                    fullscreen: true
                })
            }
        },
        onEscape: function (a) {
            a.keyCode == 27 && e.fullscreen();
            a.keyCode == 39 && e.show("next");
            a.keyCode == 37 && e.show("prev");
            a.keyCode == 38 && e.items.albums && e.albums.show(0, e.cAlbum, false, true);
            a.keyCode == 40 && e.albums.hide()
        },
        onFullResize: function () {
            var a = f(window),
                c = a.width();
            a = a.height();
            c -= this.config.initValues.wDif;
            a -= this.config.initValues.hDif;
            this.resize(c, a)
        },
        resize: function (a, c) {
            this.$tn3.width(a).height(c);
            var d = a - this.config.initValues.width,
                b = c - this.config.initValues.height,
                g, i, n = this;
            if (this.items.image) {
                g = this.config.image.initValues.width + d;
                i = this.config.image.initValues.height + b;
                if (this.imager) this.imager.setSize(g, i);
                else {
                    this.items.image.width(g).height(i);
                    this.$inImage.width(g).height(i)
                }
            }
            if (this.items.thumbs) {
                g = this.config.thumbnailer.initValues.width + d;
                i = this.config.thumbnailer.initValues.height + b;
                if (this.thumbnailer) this.thumbnailer.setSize(g, i);
                else this.config.thumbnailer.initValues.vertical ? this.items.thumbs.height(i) : this.items.thumbs.width(g)
            }
            if (this.items.albums) {
                g = this.albums.initValues.width + d;
                i = this.albums.initValues.height + b;
                this.albums.changeSize(d, b)
            }
            f.each(this.special.rh, function (k, h) {
                n.items[h].width(n.config.initValues[h].w + d)
            });
            f.each(this.special.rv, function (k, h) {
                n.items[h].height(n.config.initValues[h].h + b)
            });
            this.center()
        },
        center: function () {
            var a, c = this;
            f.each(this.special.v, function (d, b) {
                a = c.items[b];
                a.css("top", (a.parent().height() - a.height()) / 2)
            });
            f.each(this.special.h, function (d, b) {
                a = c.items[b];
                a.css("left", (a.parent().width() - a.width()) / 2)
            })
        },
        trigger: function (a, c) {
            var d = f.Event("tn3_" + a),
                b;
            for (b in c) d[b] = c[b];
            if (c && c.type != undefined) d.type = "tn3_" + a;
            d.source = this;
            this.$c.trigger(d);
            this.config[a] && this.config[a].call(this, d);
            for (b in c) c[b] = d[b]
        },
        initMouseWheel: function () {
            var a = this,
                c = function (d) {
                    a.show((d.detail ? -d.detail : d.wheelDelta) > 0 ? "prev" : "next");
                    d.preventDefault()
                };
            this.$tn3.bind("mousewheel", c);
            this.$tn3.bind("DOMMouseScroll", c)
        },
        replaceMenu: function (a, c) {
        
            var d = '<div style="position:absolute;background-color:#fff;color: #000;padding:0px 4px 0px 4px;z-index:1010;font-family:sans-serif;font-size:12px;"><a href="' + c + '">' + a + "</a></div>";
            
            this.$tn3.bind("contextmenu", function (b) {
                b.preventDefault()
            }).bind("mousedown", function (b) {
                if (b.which == 3) {
                    var g = f("body").append(d).find("div:last");
                    g.css("left", b.pageX).css("top", b.pageY);
                    g.find("a").mouseup(function (i) {
                        window.location = c;
                        g.unbind(i)
                    });
                    f("body").mouseup(function (i) {
                        g.remove();
                        f("body").unbind(i)
                    })
                }
            })
        }
    }
})(jQuery);
(function (f) {
    f.fn.tn3.Imager = function (e, a, c) {
        this.$c = e;
        this.data = a;
        c.crop = false;
        this.config = f.extend(true, {}, f.fn.tn3.Imager.config, c);
        this.init()
    };
    f.fn.tn3.Imager.config = {
        transitions: null,
        defaultTransition: {
            type: "slide"
        },
        random: false,
        cssID: "tn3",
        maxZoom: 1.4,
        crop: false,
        clickEvent: "click",
        idleDelay: 3E3,
        dif: 0
    };
    f.fn.tn3.Imager.prototype = {
        config: null,
        $c: false,
        data: false,
        cached: null,
        active: -1,
        $active: false,
        $buffer: false,
        isInTransition: false,
        ts: null,
        cDim: null,
        qid: null,
        currentlyLoading: null,
        side: null,
        $ic: null,
        $binder: null,
        infoID: null,
        lastEnter: false,
        mouseCoor: {
            x: 0,
            y: 0
        },
        mouseIsOver: false,
        init: function () {
            this.$c.css("overflow", "hidden");
            this.$c.css("position", "relative");
            this.bindMouseEvents(this.$c);
            this.cached = [];
            this.ts = new f.fn.tn3.Transitions(this.config.transitions, this.config.defaultTransition, this.config.random, this, "onTransitionEnd")
        },
        bindMouseEvents: function (e) {
            this.unbindMouseEvents();
            var a = this;
            e.hover(function () {
                a.mouseIsOver = true;
                a.enterLeave("enter");
                a.startIdle();
                f(document).mousemove(f.proxy(a.onMouseMove, a))
            }, function () {
                a.mouseIsOver = false;
                a.enterLeave("leave");
                a.stopIdle();
                f(document).unbind("mousemove", a.onMouseMove)
            });
            e[this.config.clickEvent](function (c) {
                a.active == -1 || a.isInTransition || c.target.tagName.toUpperCase() != "A" && a.trigger("click", {
                    n: a.active
                })
            });
            this.$binder = e
        },
        unbindMouseEvents: function () {
            this.$binder && this.$binder.unbind("mouseenter mouseleave " + this.config.clickEvent);
            f(document).unbind("mousemove", this.onMouseMove);
            this.stopIdle()
        },
        startIdle: function () {
            this.stopIdle();
            var e = this;
            if (this.config.idleDelay > 0) this.infoID = setTimeout(function () {
                e.enterLeave("leave");
                e.stopIdle()
            }, this.config.idleDelay)
        },
        onMouseMove: function (e) {
            this.mouseCoor = {
                x: e.pageX,
                y: e.pageY
            };
            if (!this.isInTransition) {
                this.infoID || this.enterLeave("enter");
                this.startIdle()
            }
        },
        stopIdle: function () {
            clearTimeout(this.infoID);
            this.infoID = null
        },
        enterLeave: function (e) {
            this.lastEnter != e && this.trigger(e);
            this.lastEnter = e
        },
        show: function (e) {
            if (this.isInTransition) this.qid = e;
            else {
                this.qid = null;
                if (e == "next") {
                    e = this.active + 1 < this.data.length ? this.active + 1 : 0;
                    this.side = "left"
                } else if (e == "prev") {
                    e = this.active > 0 ? this.active - 1 : this.data.length - 1;
                    this.side = "right"
                } else this.side = this.active > e ? "right" : "left";
                this.trigger("load_start", {
                    n: e
                });
                this.$buffer = this.$c.prepend('<div class="' + this.config.cssID + '-image-in" style="position:absolute;overflow:hidden;"></div>').find(":first");
                if (this.cached[this.currentlyLoading] != undefined) this.cached[this.currentlyLoading].init = false;
                if (this.cached[e] != undefined) if (this.cached[e].status == "loaded") this.initImage(this.cached[e].loader.$img, e);
                else {
                    this.cached[e].init = true;
                    this.currentlyLoading = e
                } else {
                    this.cached[e] = {
                        status: "loading",
                        init: true
                    };
                    this.currentlyLoading = e;
                    this.cached[e].loader = new f.fn.tn3.ImageLoader(this.data[e].img, this, this.onCacheLoad, [e])
                }
            }
        },
        onCacheLoad: function (e, a, c) {
            this.cached[a].status = "loaded";
            c && this.trigger("error", {
                description: c,
                n: a
            });
            this.cached[a].init && this.initImage(e, a)
        },
        initImage: function (e, a) {
            this.currentlyLoading = null;
            this.active = a;
            if (!this.cDim) this.cDim = {
                w: this.$c.width(),
                h: this.$c.height()
            };
            this.$buffer.width(this.cDim.w).height(this.cDim.h);
            var c = f('<div class="' + this.config.cssID + '-full-image" style="position:absolute"></div>');
            e.appendTo(c);
            this.$buffer.append(c);
            this.$buffer.data("ic", c);
            this.$buffer.data("img", e);
            this.resize(this.$buffer);
            this.trigger("load_end", {
                n: a
            });
            if (this.$active != false) {
                this.isInTransition = true;
                this.unbindMouseEvents();
                if (this.mouseIsOver) f(document).mousemove(f.proxy(this.onMouseMove, this));
                else this.mouseCoor = {
                    x: 0,
                    y: 0
                };
                this.lastEnter = "leave";
                this.ts.start(this.$active, this.$buffer, this.side)
            } else {
                this.$active = this.$buffer;
                this.trigger("transition", {
                    n: this.active
                })
            }
            if (this.cached[a + 1] == undefined && this.data[a + 1] != undefined) {
                this.cached[a + 1] = {
                    status: "loading",
                    init: false
                };
                this.cached[a + 1].loader = new f.fn.tn3.ImageLoader(this.data[a + 1].img, this, this.onCacheLoad, [a + 1])
            }
        },
        setSize: function (e, a) {
            this.isInTransition && this.ts.stop(this.$active, this.$buffer, this.ts.config);
            this.$c.width(e).height(a);
            this.cDim = {
                w: this.$c.width(),
                h: this.$c.height()
            };
            if (this.$active) {
                this.$active.width(e).height(a);
                this.resize(this.$active)
            }
        },
        resize: function (e) {
            $img = e.data("img");
            if ($img == undefined) this.trigger("resize", {
                w: this.cDim.w,
                h: this.cDim.h,
                left: 0,
                top: 0
            });
            else {
                $ic = e.data("ic");
                $img.width("").height("");
                e.data("scaled", false);
                var a = $img.width(),
                    c = $img.height(),
                    d = 0,
                    b = 0,
                    g = {
                        w: a,
                        h: c,
                        left: 0,
                        top: 0
                    };
                if (a != this.cDim.w || c != this.cDim.h) {
                    d = this.cDim.w / a;
                    b = this.cDim.h / c;
                    d = this.config.crop ? Math.max(d, b) : Math.min(d, b);
                    d = Math.min(this.config.maxZoom, d);
                    a = g.w = Math.round(a * d) - this.config.dif;
                    c = g.h = Math.round(c * d) - this.config.dif;
                    if (this.cDim.w >= a) d = g.left = (this.cDim.w - a) / 2;
                    else {
                        d = -(a - this.cDim.w) * 0.5;
                        g.w = this.cDim.w
                    }
                    if (this.cDim.h > c) b = g.top = (this.cDim.h - c) / 2;
                    else {
                        b = -(c - this.cDim.h) * 0.5;
                        g.h = this.cDim.h
                    }
                    $img.width(a).height(c);
                    $ic.width(a).height(c);
                    e.data("scaled", true)
                }
                $ic.css("left", d).css("top", b);
                this.bindMouseEvents($ic);
                this.trigger("resize", g)
            }
        },
        onTransitionEnd: function () {
            this.$active.remove();
            this.$active = this.$buffer;
            this.isInTransition = false;
            this.trigger("transition", {
                n: this.active
            });
            this.bindMouseEvents(this.$binder);
            var e = this.$binder.offset();
            this.mouseIsOver = false;
            if (this.mouseCoor.x >= e.left && this.mouseCoor.x <= e.left + this.$binder.width()) if (this.mouseCoor.y >= e.top && this.mouseCoor.y <= e.top + this.$binder.height()) {
                this.lastEnter = "leave";
                this.enterLeave("enter");
                this.startIdle();
                this.mouseIsOver = true;
                f(document).mousemove(f.proxy(this.onMouseMove, this))
            }
            this.qid != null && this.show(this.qid)
        },
        trigger: function (e, a) {
            var c = f.Event("img_" + e),
                d;
            for (d in a) c[d] = a[d];
            c.source = this;
            this.$c.trigger(c);
            this.config[e] && this.config[e].call(this, c)
        },
        destroy: function () {
            this.isInTransition && this.ts.stop(this.$active, this.$buffer);
            this.$active && this.$active.remove();
            this.$buffer.remove()
        },
        rebuild: function (e) {
            this.quid = null;
            this.isInTransition && this.ts.stop(this.$active, this.$buffer);
            this.$buffer.remove();
            this.cached = [];
            this.data = e;
            this.loader && this.loader.cancel()
        }
    }
})(jQuery);
(function (f) {
    f.fn.tn3.Thumbnailer = function (e, a, c) {
        this.$c = e;
        this.data = a;
        this.config = f.extend({}, f.fn.tn3.Thumbnailer.config, c);
        this.init()
    };
    f.fn.tn3.Thumbnailer.config = {
        overMove: true,
        buffer: 20,
        speed: 8,
        slowdown: 50,
        shaderColor: "#000000",
        shaderOpacity: 0.5,
        shaderDuration: 300,
        shaderOut: 300,
        useTitle: false,
        seqLoad: true,
        align: 1,
        mode: "thumbs",
        cssID: "tn3"
    };
    f.fn.tn3.Thumbnailer.prototype = {
        config: null,
        $c: null,
        $oc: null,
        $ul: null,
        data: null,
        active: -1,
        listSize: 0,
        containerSize: 0,
        containerPadding: 0,
        noBufSize: 0,
        containerOffset: 0,
        mcoor: "mouseX",
        edge: "left",
        size: "width",
        outerSize: "outerWidth",
        mouseX: 0,
        mouseY: 0,
        intID: false,
        pos: 0,
        difference: 0,
        cnt: 1,
        thumbCount: -1,
        initialized: false,
        clickWhenReady: -1,
        loaders: null,
        lis: null,
        isVertical: null,
        marginDif: 0,
        nloaded: 0,
        init: function () {
            this.$c.css("position", "absolute").css("cursor", "progress");
            this.lis = [];
            this.loaders = [];
            this.initialized = false;
            this.$oc = f("<div />");
            this.$ul = f("<ul />");
            this.$oc.appendTo(this.$c);
            this.$oc.css("position", "absolute").css("overflow", "hidden").width(this.$c.width()).height(this.$c.height());
            this.$ul.appendTo(this.$oc);
            this.$ul.css("position", "relative").css("margin", "0px").css("padding", "0px").css("border-width", "0px").css("width", "12000px").css("list-style", "none");
            if (this.isVertical == null) {
                this.isVertical = this.$c.width() < this.$c.height();
                if (this.isVertical = false) {
                    this.mcoor = "mouseY";
                    this.edge = "top";
                    this.size = "height";
                    this.outerSize = "outerHeight"
                } else {
                    this.mcoor = "mouseX";
                    this.edge = "left";
                    this.size = "width";
                    this.outerSize = "outerWidth"
                }
                this.containerSize = this.$oc[this.size]();
                this.noBufSize = this.containerSize - 2 * this.config.buffer;
                this.containerOffset = this.$oc.offset()[this.edge];
                this.containerPadding = parseInt(this.$c.css("padding-" + this.edge))
            }
            this.listSize = 0;
            if (navigator.userAgent.indexOf("MSIE") != -1) this.config.seqLoad = false;
            this.loadNextThumb()
        },
        loadNextThumb: function () {
            this.thumbCount++;
            var e = this.$ul.append("<li></li>").find(":last");
            if (this.config.mode == "thumbs") {
                var a = this.data[this.thumbCount].thumb;
                if (a) {
                    this.loaders.push(new f.fn.tn3.ImageLoader(a, this, this.onLoadThumb, [e, this.thumbCount]));
                    !this.config.seqLoad && this.thumbCount < this.data.length - 1 && this.loadNextThumb();
                    return
                } else this.config.mode = "bullets"
            }
            this.config.mode == "numbers" && e.text(this.thumbCount + 1);
            this.onLoadThumb(null, e, this.thumbCount)
        },
        onLoadThumb: function (e, a, c, d) {
            this.lis[c] = {
                li: a
            };
            a.addClass(this.config.cssID + "-thumb");
            a.css("float", this.isVertical ? "none" : "left");
            if (e) {
                var b = this.lis[c].thumb = a.append(e).find(":last");
                this.lis[c].pos = a.position()[this.edge]
            }
            this.config.useTitle && a.attr("title", this.data[c].title);
            if (this.config.mode == "thumbs") {
                this.lis[c].shade = a.prepend("<div/>").find(":first");
                this.lis[c].shade.css("background-color", this.config.shaderColor).css("width", b.width()).css("height", b.height()).css("position", "absolute")
            }
            this.initThumb(c);
            a.css("opacity", 0);
            a.animate({
                opacity: 1
            }, 1E3);
            this.listSize += a[this.outerSize](true);
            if (!this.initialized) {
                this.initialized = true;
                this.initMouse(true)
            }
            d && this.trigger("error", {
                description: d,
                n: c
            });
            this.trigger("thumbLoad", {
                n: c
            });
            this.nloaded++;
            if (this.nloaded < this.data.length) {
                if (this.config.seqLoad || this.config.mode != "thumbs") this.loadNextThumb()
            } else {
                if (e) this.loaders = null;
                if (!this.config.seqLoad) for (e = 0; e < this.lis.length; e++) this.lis[e].pos = this.lis[e].li.position()[this.edge];
                this.thumbsLoaded()
            }
            if (this.clickWhenReady == c) {
                this.clickWhenReady = -1;
                this.thumbClick(c)
            }
        },
        initThumb: function (e) {
            var a = this.lis[e];
            if (a.li) {
                a.li.removeClass().addClass(this.config.cssID + "-thumb");
                if (a.shade) {
                    a.shade.stop();
                    a.shade.css("opacity", this.config.shaderOpacity)
                }
                var c = this;
                a.li.click(function () {
                    c.thumbClick(e);
                    c.trigger("click", {
                        n: e
                    });
                    return false
                });
                this.config.mode != "thumbs" && a.li.hover(function () {
                    c.mouseOver(e)
                }, function () {
                    c.mouseOver(-1)
                })
            }
        },
        lastOver: -1,
        mouseOver: function (e) {
            if (e != this.lastOver) {
                if (this.lastOver != -1 && this.lastOver != this.active) {
                    a = this.lis[this.lastOver];
                    a.li.removeClass(this.config.cssID + "-thumb-over");
                    if (a.shade) {
                        a.shade.stop();
                        a.shade.animate({
                            opacity: this.config.shaderOpacity
                        }, {
                            duration: this.config.shaderOut,
                            easing: "easeOutCubic",
                            queue: false
                        })
                    }
                    this.trigger("thumbOut", {
                        n: e
                    })
                }
                this.lastOver = e;
                if (!(e == -1 || e == this.active)) {
                    var a = this.lis[e];
                    a.li.addClass(this.config.cssID + "-thumb-over");
                    if (a.shade) {
                        a.shade.stop();
                        a.shade.animate({
                            opacity: 0
                        }, {
                            duration: this.config.shaderDuration,
                            easing: "easeOutCubic",
                            queue: false
                        })
                    }
                    this.trigger("thumbOver", {
                        n: e
                    })
                }
            }
        },
        next: function (e) {
            if (e) this.listSize > this.containerSize && this.move(this.$ul.position()[this.edge] - this.containerSize);
            else {
                e = this.active + 1;
                if (this.active == -1 || this.active + 1 == this.data.length) e = 0;
                this.thumbClick(e)
            }
        },
        prev: function (e) {
            if (e) this.listSize > this.containerSize && this.move(this.$ul.position()[this.edge] + this.containerSize);
            else {
                e = this.active - 1;
                if (this.active == -1 || this.active == 0) e = this.data.length - 1;
                this.thumbClick(e)
            }
        },
        move: function (e) {
            var a = {};
            a[this.edge] = Math.min(0, Math.max(e, -(this.listSize - this.containerSize)));
            this.$ul.stop();
            this.$ul.animate(a, 300)
        },
        thumbClick: function (e) {
            if (this.active == -1) {
                if (this.thumbCount <= e || this.lis.length <= e) {
                    this.clickWhenReady = e;
                    return
                }
            } else if (e == this.active) return;
            else this.initThumb(this.active);
            if (e == "next") e = this.active + 1 < this.data.length ? this.active + 1 : 0;
            else if (e == "prev") e = this.active > 0 ? this.active - 1 : this.data.length - 1;
            var a = this.lis[e];
            a.li.addClass(this.config.cssID + "-thumb-selected").unbind("click mouseenter mouseleave");
            a.shade && a.shade.animate({
                opacity: 0
            }, this.config.shaderDuration);
            this.active = e;
            this.centerActive()
        },
        centerActive: function (e) {
            if (this.active != -1) {
                var a = this.lis[this.active].li,
                    c = this.$ul.position()[this.edge] + a.position()[this.edge],
                    d = a[this.outerSize]() / 2;
                if (c + d > this.containerSize || c + d < 0) {
                    a = 10 - a.position()[this.edge] + this.containerSize / 2 - d;
                    a = Math.min(0, a);
                    a = Math.max(a, -this.listSize + this.containerSize);
                    c = {};
                    c[this.edge] = a;
                    e ? this.$ul.css(c) : this.$ul.animate(c, 200)
                }
            }
        },
        thumbsLoaded: function () {
            this.$c.css("cursor", "auto");
            this.$ul.css("width", this.listSize + "px");
            this.centerList();
            this.trigger("load")
        },
        centerList: function (e) {
            if (this.listSize < this.containerSize) {
                var a = {};
                a[this.edge] = this.config.align ? this.config.align == 1 ? (this.containerSize - this.listSize) / 2 : this.containerSize - this.listSize : 0;
                e || this.config.mode != "thumbs" ? this.$ul.css(a) : this.$ul.animate(a, 300)
            } else {
                this.centerActive(e);
                if (this.$ul.position()[this.edge] > 0) this.$ul.css(this.edge, 0);
                else this.$ul.position()[this.edge] + this.listSize < this.containerSize && this.$ul.css(this.edge, -(this.listSize - this.containerSize))
            }
        },
        initMouse: function (e) {
            if (this.config.mode == "thumbs") {
                e = e ? "bind" : "unbind";
                this.$oc[e]("mouseenter", f.proxy(this.mouseenter, this));
                this.$oc[e]("mouseleave", f.proxy(this.mouseleave, this))
            }
        },
        mouseenter: function () {
            this.trigger("over");
            clearInterval(this.intID);
            var e = this;
            this.$ul.stop();
            this.$c.mousemove(this.mcoor == "mouseX" ?
            function (a) {
                e.mouseX = a.pageX - e.containerOffset
            } : function (a) {
                e.mouseY = a.pageY - e.containerOffset
            });
            this.marginDif = parseInt(this.lis[0].li.css("margin-" + this.edge));
            if (isNaN(this.marginDif)) this.marginDif = 0;
            e.intID = this.listSize > this.containerSize && this.config.overMove ? setInterval(function () {
                e.slide.call(e)
            }, 10) : setInterval(function () {
                e.mouseTrack.call(e)
            }, 10)
        },
        mouseleave: function () {
            this.trigger("out");
            this.$c.unbind("mousemove");
            clearInterval(this.intID);
            var e = this;
            this.intID = setInterval(function () {
                e.slideOut.call(e)
            }, 10);
            this.mouseOver(-1)
        },
        slide: function () {
            this.cnt = 1;
            var e = this[this.mcoor];
            if (e <= this.config.buffer) this.pos = 0;
            else if (e >= this.containerSize - this.config.buffer) this.pos = this.containerSize - this.listSize - 1;
            else {
                var a = this.containerSize * (e - this.config.buffer);
                a /= this.noBufSize;
                this.pos = a * (1 - this.listSize / this.containerSize)
            }
            for (a = this.lis.length - 1; a > -1; a--) {
                var c = e - this.prevdx;
                if (c >= this.lis[a].pos && c < this.lis[a].pos + this.lis[a].li.width()) {
                    this.mouseOver(a);
                    break
                }
            }
            e = this.prevdx - this.marginDif;
            this.difference = e - this.pos;
            e = Math.round(e - this.difference / this.config.speed);
            if (this.prevdx != e) {
                this.$ul.css(this.edge, e);
                this.prevdx = e
            }
        },
        prevdx: 0,
        mouseTrack: function () {
            for (var e = this[this.mcoor], a = this.lis.length - 1; a > -1; a--) {
                var c = e - this.$ul.position()[this.edge];
                if (c >= this.lis[a].pos && c < this.lis[a].pos + this.lis[a].li.width()) {
                    this.mouseOver(a);
                    break
                }
            }
        },
        slideOut: function () {
            if (this.config.slowdown != 0 && this.difference != 0) {
                var e = this.$ul.position()[this.edge];
                this.difference = e - this.pos;
                this.$ul.css(this.edge, e - this.difference / (this.config.speed * this.cnt));
                this.cnt *= 1 + 4 / this.config.slowdown;
                if (this.cnt >= 40) {
                    this.difference = 0;
                    this.cnt = 1
                }
            } else {
                clearInterval(this.intID);
                this.intID = null
            }
        },
        trigger: function (e, a) {
            var c = f.Event("tn_" + e),
                d;
            for (d in a) c[d] = a[d];
            c.source = this;
            this.$c.trigger(c);
            this.config[e] && this.config[e].call(this, c)
        },
        destroy: function () {
            clearInterval(this.intID);
            this.$c.empty()
        },
        rebuild: function (e) {
            clearInterval(this.intID);
            this.$c.empty();
            this.data = e;
            this.active = this.thumbCount = -1;
            this.nloaded = 0;
            this.initMouse(false);
            this.loaders !== null && f.each(this.loaders, function (a, c) {
                c.cancel()
            });
            this.init()
        },
        setSize: function (e, a) {
            this.isVertical ? this.$c.height(a) : this.$c.width(e);
            this.$oc.width(this.$c.width()).height(this.$c.height());
            this.containerSize = this.$oc[this.size]();
            this.noBufSize = this.containerSize - 2 * this.config.buffer;
            this.containerOffset = this.$oc.offset()[this.edge];
            this.initMouse(true);
            this.loaders === null && this.centerList(true)
        }
    }
})(jQuery);
(function (f) {
    f.fn.tn3.altLink = null;
    f.fn.tn3.ImageLoader = function (e, a, c, d) {
        this.$img = f(new Image);
        d.unshift(this.$img);
        this.altLink = f.fn.tn3.altLink;
        a = {
            url: e,
            context: a,
            callback: c,
            args: d
        };
        this.$img.bind("load", a, this.load);
        this.$img.bind("error", a, f.proxy(this.error, this));
        this.$img.attr("src", e)
    };
    f.fn.tn3.ImageLoader.prototype = {
        $img: null,
        altLink: null,
        load: function (e) {
            e.data.callback.apply(e.data.context, e.data.args);
            e.data.args[0].unbind("load").unbind("error")
        },
        error: function (e) {
            if (this.altLink) {
                this.altLink = null;
                this.$img.attr("src", f.fn.tn3.altLink + "?u=" + e.data.url)
            } else {
                e.data.args.push("image loading error: " + e.data.url);
                e.data.callback.apply(e.data.context, e.data.args);
                this.$img.unbind("load").unbind("error")
            }
        },
        cancel: function () {
            this.$img.unbind("load").unbind("error")
        }
    }
})(jQuery);
(function (f) {
    f.fn.tn3.Timer = function (e, a, c) {
        this.$target = e;
        this.duration = a;
        this.tickint = c
    };
    f.fn.tn3.Timer.prototype = {
        $target: null,
        duration: null,
        id: null,
        runs: false,
        counter: null,
        countDuration: null,
        tickid: null,
        ticks: null,
        tickint: 500,
        start: function () {
            if (!this.runs) {
                this.runs = true;
                this.startCount(this.duration);
                this.trigger("timer_start")
            }
        },
        startCount: function (e) {
            this.clean();
            this.countDuration = e;
            this.counter = +new Date;
            var a = this;
            this.id = setTimeout(function () {
                a.clean.call(a);
                a.runs = false;
                a.trigger.call(a, "timer_end")
            }, e);
            var c = this.duration / this.tickint;
            this.ticks = Math.round(e / c);
            this.tickid = setInterval(function () {
                a.ticks = Math.ceil((e - new Date + a.counter) / c);
                a.ticks > 0 && a.trigger.call(a, "timer_tick", {
                    tick: a.ticks,
                    totalTicks: a.tickint
                })
            }, c);
            this.trigger("timer_tick", {
                tick: this.ticks,
                totalTicks: this.tickint
            })
        },
        stop: function () {
            this.clean();
            this.runs = false;
            this.trigger("timer_stop")
        },
        clean: function () {
            clearTimeout(this.id);
            this.id = null;
            clearInterval(this.tickid);
            this.elapsed = this.tickid = null
        },
        elapsed: null,
        pause: function (e) {
            if (this.runs) if (e) {
                this.clean();
                e = this.duration / this.tickint;
                this.elapsed = Math.floor((+new Date - this.counter) / e) * e
            } else if (this.elapsed != null) {
                this.startCount(this.countDuration - this.elapsed);
                this.elapsed = null
            }
        },
        trigger: function (e, a) {
            var c = f.Event(e),
                d;
            for (d in a) c[d] = a[d];
            this.$target.trigger(c)
        }
    }
})(jQuery);
(function (f) {
    var e = f.fn.tn3.Transitions = function (c, d, b, g, i) {
            this.ts = c;
            this.def = f.extend(true, {}, this[d.type + "Config"], d);
            if (!c) this.ts = [this.def];
            for (var n in this.ts) this.ts[n] = f.extend(true, {}, this[this.ts[n].type + "Config"], this.ts[n]);
            this.random = b;
            this.end = f.proxy(g, i)
        },
        a = e.prototype = {
            ts: null,
            def: {
                type: "slide"
            },
            random: false,
            gs: [],
            end: null,
            ct: null,
            counter: -1,
            setTransition: function () {
                if (this.ts.length == 1) this.ct = this.ts[0];
                else {
                    this.counter++;
                    if (this.counter == this.ts.length) this.counter = 0;
                    this.random && this.counter == 0 && f.fn.tn3utils.shuffle(this.ts);
                    this.ct = this.ts[this.counter]
                }
            },
            start: function (c, d, b) {
                this.setTransition();
                if (this[this.ct.type + "Condition"] !== undefined && !this[this.ct.type + "Condition"](c, d, this.ct)) this.ct = this.def;
                this[this.ct.type](c, d, this.ct, b)
            },
            stop: function (c, d) {
                this[this.ct.type + "Stop"](c, d, this.ct)
            },
            makeGrid: function (c, d, b) {
                var g = c.width(),
                    i = Math.round(g / d);
                g = g - i * d;
                var n = c.height(),
                    k = Math.round(n / b);
                n = n - k * b;
                var h, j, l, m, p, q = 0,
                    r = 0,
                    t = "url(" + c.find("img").attr("src") + ") no-repeat scroll -";
                for (h = 0; h < d; h++) {
                    this.gs[h] = [];
                    m = g > h ? i + 1 : i;
                    for (j = 0; j < b; j++) {
                        l = c.append("<div></div>").find(":last");
                        p = n > j ? k + 1 : k;
                        l.width(m).height(p).css("background", t + q + "px -" + r + "px").css("left", q).css("top", r).css("position", "absolute");
                        this.gs[h].push(l);
                        r += p
                    }
                    q += m;
                    r = 0
                }
                c.find("img").remove()
            },
            stopGrid: function () {
                for (var c = 0; c < this.gs.length; c++) for (var d = 0; d < this.gs[c].length; d++) {
                    this.gs[c][d].clearQueue();
                    this.gs[c][d].remove()
                }
                this.gs = []
            },
            flatSort: function (c) {
                for (var d = [], b = 0; b < this.gs.length; b++) for (var g = 0; g < this.gs[b].length; g++) d.push(this.gs[b][g]);
                c && d.reverse();
                return d
            },
            randomSort: function () {
                var c = this.flatSort();
                f.fn.tn3utils.shuffle(c);
                return c
            },
            diagonalSort: function (c, d) {
                for (var b = [], g = c > 0 ? this.gs.length - 1 : 0, i = d > 0 ? 0 : this.gs[0].length - 1; this.gs[g];) {
                    b.push(this.addDiagonal([], g, i, c, d));
                    g -= c
                }
                g += c;
                for (i += d; this.gs[g][i];) {
                    b.push(this.addDiagonal([], g, i, c, d));
                    i += d
                }
                return b
            },
            addDiagonal: function (c, d, b, g, i) {
                c.push(this.gs[d][b]);
                return this.gs[d + g] && this.gs[d + g][b + i] ? this.addDiagonal(c, d + g, b + i, g, i) : c
            },
            circleSort: function (c) {
                var d = [],
                    b = this.gs.length,
                    g = this.gs[0].length,
                    i = [Math.floor(b / 2), Math.floor(g / 2)];
                b = b * g;
                g = [
                    [1, 0],
                    [0, 1],
                    [-1, 0],
                    [0, -1]
                ];
                var n = 0,
                    k = 0,
                    h;
                for (d.push(this.gs[i[0]][i[1]]); d.length < b;) {
                    for (h = 0; h <= n; h++) this.addGridPiece(d, i, g[k]);
                    if (k == g.length - 1) k = 0;
                    else k++;
                    n += 0.5
                }
                c && d.reverse();
                return d
            },
            addGridPiece: function (c, d, b) {
                d[0] += b[0];
                d[1] += b[1];
                this.gs[d[0]] && this.gs[d[0]][d[1]] && c.push(this.gs[d[0]][d[1]])
            },
            getSlidePositions: function (c, d) {
                var b = {
                    dir: d
                };
                switch (d) {
                case "left":
                    b.pos = c.outerWidth(true);
                    break;
                case "right":
                    b.pos = -c.outerWidth(true);
                    b.dir = "left";
                    break;
                case "top":
                    b.pos = -c.outerHeight(true);
                    break;
                case "bottom":
                    b.pos = c.outerHeight(true);
                    b.dir = "top"
                }
                return b
            },
            animateGrid: function (c, d, b, g, i, n, k) {
                var h = {
                    duration: g,
                    easing: b,
                    complete: function () {
                        f(this).remove()
                    }
                };
                for (b = 0; b < c.length; b++) {
                    g = f.easing[i](0, b, 0, n, c.length);
                    if (b == c.length - 1) {
                        var j = this;
                        h.complete = function () {
                            f(this).remove();
                            k.call(j)
                        }
                    }
                    if (f.isArray(c[b])) for (var l in c[b]) c[b][l].delay(g).animate(d[b], h);
                    else c[b].delay(g).animate(d[b], h)
                }
            },
            getValueArray: function (c, d, b) {
                var g = [],
                    i = f.isArray(d),
                    n = f.isArray(b),
                    k;
                for (k = 0; k < c; k++) {
                    o = {};
                    o[i ? d[k % d.length] : d] = n ? b[k % b.length] : b;
                    g.push(o)
                }
                return g
            }
        };
    e.defined = [];
    e.define = function (c) {
        for (var d in c) switch (d) {
        case "type":
            e.defined.push(c.type);
            break;
        case "config":
            a[c.type + "Config"] = c.config;
            break;
        case "f":
            a[c.type] = c.f;
            break;
        case "stop":
            a[c.type + "Stop"] = c.stop;
            break;
        case "condition":
            a[c.type + "Condition"] = c.condition;
            break;
        default:
            a[d] = c[d]
        }
    };
    e.define({
        type: "none",
        config: {},
        f: function () {
            this.end()
        },
        stop: function () {
            this.end()
        }
    });
    e.define({
        type: "fade",
        config: {
            duration: 300,
            easing: "easeInQuad"
        },
        f: function (c, d, b) {
            var g = this;
            c.animate({
                opacity: 0
            }, b.duration, b.easing, function () {
                g.end()
            })
        },
        stop: function (c) {
            c.stop();
            this.end()
        }
    });
    e.define({
        type: "slide",
        config: {
            duration: 300,
            direction: "auto",
            easing: "easeInOutCirc"
        },
        f: function (c, d, b, g) {
            g = this.getSlidePositions(d, b.direction == "auto" ? g : b.direction);
            var i = {},
                n = {};
            d.css(g.dir, g.pos);
            i[g.dir] = 0;
            d.animate(i, b.duration, b.easing, this.end);
            n[g.dir] = -g.pos;
            c.animate(n, b.duration, b.easing)
        },
        stop: function (c, d) {
            d.stop();
            c.stop();
            c.css("left", 0).css("top", 0);
            d.css("left", 0).css("top", 0);
            this.end()
        }
    });
    e.define({
        type: "blinds",
        config: {
            duration: 240,
            easing: "easeInQuad",
            direction: "vertical",
            parts: 12,
            partDuration: 100,
            partEasing: "easeInQuad",
            method: "fade",
            partDirection: "auto",
            cross: true
        },
        f: function (c, d, b, g) {
            b.direction == "horizontal" ? this.makeGrid(c, 1, b.parts) : this.makeGrid(c, b.parts, 1);
            g = b.partDirection == "auto" ? g : b.partDirection;
            c = this.flatSort(g == "left" || g == "top");
            var i;
            switch (b.method) {
            case "fade":
                i = this.getValueArray(c.length, "opacity", 0);
                break;
            case "scale":
                i = this.getValueArray(c.length, g == "left" ? "width" : "height", "1px");
                break;
            case "slide":
                d = this.getSlidePositions(d, g);
                i = this.getValueArray(c.length, d.dir, b.cross ? [d.pos, -d.pos] : d.pos)
            }
            this.animateGrid(c, i, b.partEasing, b.partDuration, b.easing, b.duration, this.blindsStop)
        },
        stop: function () {
            this.stopGrid();
            this.end()
        },
        condition: function (c, d) {
            return !c.data("scaled") || !d.data("scaled")
        }
    });
    e.define({
        type: "grid",
        config: {
            duration: 260,
            easing: "easeInQuad",
            gridX: 7,
            gridY: 5,
            sort: "diagonal",
            sortReverse: false,
            diagonalStart: "bl",
            method: "fade",
            partDuration: 300,
            partEasing: "easeOutSine",
            partDirection: "left"
        },
        f: function (c, d, b, g) {
            this.makeGrid(c, b.gridX, b.gridY);
            c = b.partDirection == "auto" ? g : b.partDirection;
            var i, n;
            if (b.sort == "diagonal") switch (b.diagonalStart) {
            case "tr":
                i = this.diagonalSort(1, 1);
                break;
            case "tl":
                i = this.diagonalSort(-1, 1);
                break;
            case "br":
                i = this.diagonalSort(1, -1);
                break;
            case "bl":
                i = this.diagonalSort(-1, -1)
            } else i = this[b.sort + "Sort"](b.sortReverse);
            switch (b.method) {
            case "fade":
                n = this.getValueArray(i.length, "opacity", 0);
                break;
            case "scale":
                n = this.getValueArray(i.length, c == "left" ? "width" : "height", "1px")
            }
            this.animateGrid(i, n, b.partEasing, b.partDuration, b.easing, b.duration, this.gridStop)
        },
        stop: function () {
            this.stopGrid();
            this.end()
        },
        condition: function (c, d) {
            return !c.data("scaled") || !d.data("scaled")
        }
    })
})(jQuery);
(function (f) {
    function e(h) {
        var j = h && h.message !== undefined ? h.message : undefined;
        h = f.extend({}, f.tn3block.defaults, h || {});
        j = j === undefined ? h.message : j;
        k && a({});
        var l = h.baseZ,
            m = f.browser.msie || h.forceIframe ? f('<iframe class="blockUI" style="z-index:' + l+++';display:none;border:none;margin:0;padding:0;position:absolute;width:100%;height:100%;top:0;left:0" src="' + h.iframeSrc + '"></iframe>') : f('<div class="blockUI" style="display:none"></div>'),
            p = f('<div class="blockUI ' + h.cssID + '-overlay" style="z-index:' + l+++';display:none;border:none;margin:0;padding:0;width:100%;height:100%;top:0;left:0"></div>');
        l = f('<div class="blockUI ' + h.blockMsgClass + ' blockPage" style="z-index:' + l + ';display:none;position:fixed"></div>');
        l.css("left", "0px").css("top", "0px");
        if (!h.applyPlatformOpacityRules || !(f.browser.mozilla && /Linux/.test(navigator.platform))) p.css(h.overlayCSS);
        p.css("position", "fixed");
        if (f.browser.msie || h.forceIframe) m.css("opacity", 0);
        var q = [m, p, l],
            r = f("body");
        f.each(q, function () {
            this.appendTo(r)
        });
        q = i && (!f.boxModel || f("object,embed", null).length > 0);
        if (n || q) {
            h.allowBodyStretch && f.boxModel && f("html,body").css("height", "100%");
            f.each([m, p, l], function (t, u) {
                var s = u[0].style;
                s.position = "absolute";
                if (t < 2) {
                    s.setExpression("height", "Math.max(document.body.scrollHeight, document.body.offsetHeight)- (jQuery.boxModel?0:" + h.quirksmodeOffsetHack + ') + "px"');
                    s.setExpression("width", 'jQuery.boxModel && document.documentElement.clientWidth || document.body.clientWidth + "px"')
                } else if (h.centerY) {
                    s.setExpression("top", '(document.documentElement.clientHeight || document.body.clientHeight) / 2- (this.offsetHeight / 2)+ (blah = document.documentElement.scrollTop? document.documentElement.scrollTop: document.body.scrollTop)+ "px"');
                    s.marginTop = 0
                } else h.centerY || s.setExpression("top", '(document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop) + "px"')
            })
        }
        if (j) {
            j.data("blockUI.parent", j.parent());
            l.append(j);
            if (j.jquery || j.nodeType) f(j).show()
        }
        if ((f.browser.msie || h.forceIframe) && h.showOverlay) m.show();
        h.showOverlay && p.show();
        j && l.show();
        h.onBlock && h.onBlock();
        d(1, h);
        k = j
    }
    function a(h) {
        h = f.extend({}, f.tn3block.defaults, h || {});
        d(0, h);
        var j = f("body").children().filter(".blockUI").add("body > .blockUI");
        c(j, h)
    }
    function c(h, j) {
        h.each(function () {
            this.parentNode && this.parentNode.removeChild(this)
        });
        k.data("blockUI.parent").append(k);
        k = null;
        typeof j.onUnblock == "function" && j.onUnblock.call(j.con)
    }
    function d(h, j) {
        if (h || k)!j.bindEvents || h && !j.showOverlay || (h ? f(document).bind("mousedown mouseup keydown keypress", j, b) : f(document).unbind("mousedown mouseup keydown keypress", b))
    }
    function b(h) {
        var j = h.data;
        if (f(h.target).parents("div." + j.blockMsgClass).length > 0) return true;
        return f(h.target).parents().children().filter("div.blockUI").length == 0
    }
    var g = document.documentMode || 0,
        i = f.browser.msie && (f.browser.version < 8 && !g || g < 8),
        n = f.browser.msie && /MSIE 6.0/.test(navigator.userAgent) && !g;
    f.tn3block = function (h) {
        e(h)
    };
    f.tn3unblock = function (h) {
        a(h)
    };
    var k = undefined;
    f.tn3block.defaults = {
        message: "<h1>Please wait...</h1>",
        overlayCSS: {},
        iframeSrc: /^https/i.test(window.location.href || "") ? "javascript:false" : "about:blank",
        forceIframe: false,
        baseZ: 1E3,
        allowBodyStretch: true,
        bindEvents: true,
        showOverlay: true,
        applyPlatformOpacityRules: true,
        onBlock: null,
        onUnblock: null,
        quirksmodeOffsetHack: 4,
        blockMsgClass: "blockMsg",
        cssID: "tn3"
    }
})(jQuery);
(function (f) {
    (f.fn.tn3.External = function (e, a) {
        if (e) {
            this.context = a;
            this.reqs = e.length;
            for (var c = 0; c < e.length; c++) new f.fn.tn3.External[e[c].origin](e[c], this)
        }
    }).prototype = {
        context: null,
        reqs: 0,
        getImages: function (e, a) {
            e.origin.getImages(e, a)
        },
        setAlbumData: function (e, a) {
            this.reqs--;
            this.context.setAlbumData.call(this.context, e, a)
        },
        setImageData: function (e, a, c) {
            this.context.setImageData.call(this.context, e, a, c)
        }
    }
})(jQuery);