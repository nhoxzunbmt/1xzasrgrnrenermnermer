function showZone(n, t, i, r, u) {
    var o, rt, b, ut, g, nt, ft, p, tt, k, v, et, e, w, ct, lt, at;
    if (typeof ads_zone != "undefined" && ads_zone && (o = ads_zone["O" + n], o && o.count != 0)) {
        o.maxview > o.count && (o.maxview = o.count);
        var c = null, d = Math.floor(Math.random() * 1001) % o.count;
        o.rand && (rt = new Date, d = rt.getMinutes() % o.count);
        var f = null, h = [], a = [];
        if (i && !o.weight) {
            for (b = o.count, e = 0; e < o.count; e++) (c = "Z" + n + "_" + e, f = ads_zone[c], f == null || f.fixed) || parseInt(f.w, 10) > r && (c = "Z" + n + "_" + b, ads_zone[c] = f, b++);
            o.count = b;
            o.weight = !0
        }
        for (e = 0; e < o.count; e++) if (c = "Z" + n + "_" + e, f = ads_zone[c], f != null) if (f.fixed) h[h.length] = f, a[a.length] = f; else break;
        if (a.length > 1) for (ut = Math.floor(Math.random() * 1001) % a.length, g = 0, e = 0; e < a.length; e++) g = (ut + e) % a.length, h[e] = a[g];
        if (nt = !0, u == "right-fixed" ? (nt = !1, h.length > 1 && (ft = h, h = [], h[0] = ft[0])) : u == "right" && (h = []), nt == !0) {
            for (e = d; e < o.count; e++) (c = "Z" + n + "_" + e, f = ads_zone[c], f != null) && (f.fixed || (h[h.length] = f));
            for (e = 0; e < d; e++) (c = "Z" + n + "_" + e, f = ads_zone[c], f != null) && (f.fixed || (h[h.length] = f))
        }
        if (t || (t = "adsZone" + n + (u == null ? "" : u), document.write('<div id="' + t + '" style="' + (o.w > 0 ? "width:" + o.w + "px;" : "") + (o.h > 0 ? "height:" + o.h + "px;" : "") + '"><\/div>')), p = $("#" + t), tt = '<div id="{id}" style="float:left;{width}{height}">{body}<\/div>', ads_template && o.template > 0 && (k = ads_template["T" + o.template], k && k.Item != "" && (tt = k.Item)), p.html(""), o.count > 0 && $(window).width() > 992) {
            if (p.show(), v = $("#li-ads-banner-center") || null, v == null) return;
            v = v.find("#ads-banner-center") || null;
            v != null && (et = v.attr("style") || null, et != null && v.attr("style").indexOf("display: none;") == -1 && $("#li-ads-banner-center").show())
        }
        var s = "", l = "", it = "", ot = "", y = "", st = 0, ht = 0;
        for (e = 0; e < h.length; e++) {
            if (ht >= o.maxview) break;
            if (c = "Z" + n + "_" + e, f = h[e], f != null) {
                if (i) {
                    if (st + parseInt(f.w, 10) > i) continue;
                    st += parseInt(f.w, 10)
                }
                ht++;
                it = ads_zone.imageUrl.substring(5) + f.url;
                s = tt;
                s = s.replace("{id}", c);
                s = s.replace("{width}", "width:" + f.w + "px;");
                s = s.replace("{height}", "height:" + f.h + "px;");
                y = ads_zone.clickUrl.substring(5) + "?website=" + ads_website + "&zoneId=" + n + "&bannerId=" + f.id;
                f.media == "flash" ? (l = f.link || "", l == "" && (l = "campaign-" + f.campid), w = '<a class="ads-banner" href="' + y + '" target="' + f.target + '" rel="nofollow" label="' + l + '" id="campaign-' + f.campid + '" style="display:block;z-index:10000;width:' + f.w + "px;height:" + f.h + 'px;">', w += '<div style="width:' + f.w + "px;height:" + f.h + 'px;" onmousedown="zoneAdClick(\'' + y + "','" + f.flashvars.clickTAG + '\')" id="campaign-' + f.campid + '">', y += "&url=" + f.flashvars.clickTAG, ct = "clickTARGET=" + f.flashvars.clickTARGET + "&clickTAG=" + escape(y), w += '<embed src="' + it + '" allowsSriptAccess="never" allowNetworking="internal" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent" width="' + f.w + '" height="' + f.h + '" flashvars="' + ct + '"><\/embed>', w += "<\/div><\/a>", s = s.replace("{body}", w), p.append(s)) : f.media == "image" ? (l = f.link || "", l == "" && (l = "campaign-" + f.campid), y += "&url=" + f.link, lt = '<a class="ads-banner" href="' + y + '" target="' + f.target + '" rel="nofollow" label="' + l + '" id="campaign-' + f.campid + '"><img src="' + it + '" border="0" width="' + f.w + '" height="' + f.h + '"><\/a>', s = s.replace("{body}", lt), p.append(s)) : f.media == "html" && (s = s.replace("{body}", f.html), p.append(s));
                ot += "_" + f.id;
                gtm_banner[f.campid] == null && (gtm_banner[f.campid] = !0, dataLayer.push({
                    event: "ads-banner-view",
                    eventCategory: "mbn-banner",
                    eventLabel: "campaign-" + f.campid
                }))
            }
        }
        at = ads_zone.viewUrl.substring(5) + "?website=" + ads_website + "&zoneId=" + n + "&Ids=" + ot;
        $.ajax({url: at, cache: !1, async: !0, dataType: "text"})
    }
}

function showZoneTop(n, t) {
    var i = 0;
    if (typeof zone_top != "undefined" && (i = zone_top["C" + n]), i == 0) while (n.length > 0 && (i == null || i == 0)) i = ads_zonecode["_" + n + "C"], n = n.substr(0, n.length - 1);
    showZone(i, t, 728);
    window.setInterval("showZone(" + i + ',"' + t + '",728)', 3e4)
}

function showZoneRight(n, t, i) {
    var r = zone_right["C" + n.substr(0, 1)];
    showZone(r, t, null, null, i);
    window.setInterval("showZone(" + r + ',"' + t + '",null,null,"' + i + '")', 3e4)
}

function showZoneLeft(n, t) {
    var i = zone_left["C" + n.substr(0, 1)];
    showZone(i, t)
}

function showZoneBottom(n, t) {
    var i = zone_bottom["C" + n.substr(0, 1)];
    showZone(i, t);
    window.setInterval("showZone(" + i + ',"' + t + '")', 3e4)
}

function showZoneMicroBar(n, t) {
    var i = zone_micro.ALL;
    showZone(i, t)
}

function zoneAdClick(n, t) {
    var i, r;
    try {
        i = new Date;
        n += "&rand=" + i.getTime();
        r = new Image;
        r.src = n
    } catch (u) {
    }
    (t || "") != "" && window.open(unescape(t), "_blank")
}

function showAds() {
    if (typeof ads_zonecode == "undefined") {
        window.setTimeout("showAds()", 100);
        return
    }
    ads_cat != "" && ads_website != "" && ads_website != "toan-quoc" && (showZoneRight(ads_cat, "ads-right-top", "right-fixed"), showZoneRight(ads_cat, "ads-right-center", "right"), showZoneTop(ads_cat, "ads-banner-center"), showZoneBottom(ads_cat, "banner-bottom"))
}

function checkShowAds(n) {
    var t, i;
    if (typeof ads_zonecode == "undefined") return !1;
    if (t = 0, typeof zone_top != "undefined" && (t = zone_top["C" + n]), t == 0) while (n.length > 0 && (t == null || t == 0)) t = ads_zonecode["_" + n + "T"], n = n.substr(0, n.length - 1);
    return typeof ads_zone == "undefined" ? !1 : ads_zone ? (i = ads_zone["O" + t], !i || i.count == 0) ? !1 : !0 : !1
}

var zone_left = {},
    zone_right = {C0: 4, C1: 23, C2: 24, C3: 25, C4: 26, C5: 27, C6: 28, C7: 29, C8: 30, C9: 31, CA: 32},
    zone_bottom = {C0: 5, C1: 44, C2: 45, C3: 46, C4: 47, C5: 48, C6: 49, C7: 50, C8: 51, C9: 52, CA: 53},
    zone_micro = {ALL: 43}, gtm_banner = {}, mbnClassifiedAds, mbnListController, mbnList;
showAds();
mbnClassifiedAds = function (n) {
    var t = function () {
        var t = this, r;
        t.IsDeviceMobile = mbnUtils.IsResponsive_XS();
        t.owl = n("#owl-carousel-ads");
        t.owlInited = !1;
        t.box = n("#mbn-classified-ads");
        t.btnNext = n("#mbn-classified-ads-next");
        t.btnPrev = n("#mbn-classified-ads-prev");
        t.classifiedAds = {};
        t.mode = 0;
        t.pageIndex = 1;
        t.pageSize = 5;
        t.total = mbnSetting.TotalClassifiedAds() || 0;
        t.city = mbnSetting.DistrictCode() > 0 ? mbnSetting.DistrictCode() : mbnSetting.CityCode();
        t.cat = mbnSetting.CategoryCode() || "";
        t.hasNext = function () {
            return t.pageIndex * t.pageSize < t.total
        };
        t.hasPrev = function () {
            return t.pageIndex > 1
        };
        t.btnDisabled = function (n, t) {
            t ? n.attr("disabled", "disabled") : n.removeAttr("disabled")
        };
        t.getData = function () {
            var n = t.classifiedAds[t.pageIndex];
            if (n) {
                t.box.html(n);
                return
            }
            mbnListController.GetClassifiedAds(t.city, t.cat, t.pageIndex, t.pageSize, t.mode).done(function (n) {
                n && (t.box.html(n), t.classifiedAds[t.pageIndex] = n)
            })
        };
        t.btnNext.click(function () {
            if (t.IsDeviceMobile == !0) {
                t.owl.trigger("owl.next");
                return
            }
            if (t.hasNext() == !1) {
                t.btnDisabled(t.btnNext, !1);
                return
            }
            t.pageIndex += 1;
            t.btnDisabled(t.btnNext, !t.hasNext());
            t.btnDisabled(t.btnPrev, !1);
            t.getData()
        });
        t.btnPrev.click(function () {
            if (t.IsDeviceMobile == !0) {
                t.owl.trigger("owl.prev");
                return
            }
            if (t.hasPrev() == !1) {
                t.btnDisabled(t.btnPrev, !1);
                return
            }
            t.pageIndex -= 1;
            t.btnDisabled(t.btnNext, !1);
            t.btnDisabled(t.btnPrev, !t.hasPrev());
            t.getData()
        });
        t.GetOwlCarouselAds = function () {
            if (t.owlInited != !0) {
                t.owlInited = !0;
                var f = "", r = t.box.children(), u = r.length - (r.length >= t.total ? 0 : r.length % 2);
                for (u = Math.min(10, u), i = 0; i < u; i += 2) f += '<div class="item">' + n(r[i]).html() + (i + 1 < u ? n(r[i + 1]).html() : "") + "<\/div>";
                t.owl.pageIndex = 1;
                t.owl.pageSize = u;
                t.owl.nextPage = !1;
                t.owl.total = t.total;
                t.owl.html(f);
                t.owl.owlCarousel({
                    itemsCustom: [[0, 1]],
                    scrollPerPage: !0,
                    lazyLoad: !0,
                    pagination: !1,
                    rewindNav: !0,
                    beforeMove: function () {
                        var n = t.owl.data("owlCarousel");
                        t.owl.nextPage != !1 && t.owl.loading != !0 && (n.itemsAmount * 2 >= t.owl.total || (n.itemsAmount <= 10 && (t.owl.pageIndex = 1, t.owl.pageSize = n.itemsAmount * 2), t.owl.css("display", "none"), t.owl.pageIndex += 1, mbnListController.GetClassifiedAds(t.city, t.cat, t.owl.pageIndex, t.owl.pageSize, 1).done(function (i) {
                            if (i) {
                                t.owl.loading = !0;
                                t.owl.nextPage == !1;
                                var r = n.maximumItem + n.options.items;
                                n.addItem(i, -1);
                                n.jumpTo(r, !0);
                                t.owl.loading = !1
                            }
                        })))
                    },
                    afterMove: function () {
                        var n = t.owl.data("owlCarousel");
                        t.owl.nextPage = n.currentItem == n.maximumItem
                    }
                })
            }
        };
        t.btnDisabled(t.btnPrev, !t.hasPrev());
        t.classifiedAds[t.pageIndex] = t.box.html();
        r = t.total > t.pageSize;
        t.total > 0 && mbnUtils.IsResponsive_XS() && (t.GetOwlCarouselAds(), t.btnDisabled(t.btnNext, !1), t.btnDisabled(t.btnPrev, !1), r = t.total > 2);
        r == !1 && (t.btnNext.hide(), t.btnPrev.hide());
        n(window).resize(function () {
            t.IsDeviceMobile = mbnUtils.IsResponsive_XS();
            t.total > 0 && mbnUtils.IsResponsive_XS() && t.GetOwlCarouselAds();
            t.IsDeviceMobile ? (t.btnDisabled(t.btnNext, !1), t.btnDisabled(t.btnPrev, !1)) : (t.btnDisabled(t.btnNext, !t.hasNext()), t.btnDisabled(t.btnPrev, !t.hasPrev()))
        })
    };
    return {ClassifiedAds: t}
}(jQuery, mbnConf, mbnUtils);
mbnListController = function (n, t) {
    var i = function (i, r, u) {
        return n.ajax({url: t.Routes.list.GetFilterDisplay, data: {city: i, cat: r, uid: u}, type: "POST"})
    }, r = function (i) {
        return n.ajax({
            url: t.Routes.list.GetPageMore,
            data: JSON.stringify({query: i}),
            type: "POST",
            dataType: "json",
            contentType: "application/json; charset=utf-8"
        })
    }, u = function (i, r, u, f) {
        return n.ajax({
            async: !1,
            url: t.Routes.list.GetClassifiedSpecials,
            data: {city: i, cat: r, pageIndex: u, pageSize: f},
            type: "POST"
        })
    }, f = function (i, r, u, f, e) {
        return n.ajax({
            async: !1,
            url: t.Routes.list.GetClassifiedAds,
            data: {city: i, cat: r, pageIndex: u, pageSize: f, mode: e},
            type: "POST"
        })
    }, e = function (t) {
        return n.ajax({url: mbnRoutes.list.GenMobileImage, data: {userId: t}, type: "POST"})
    };
    return {GetFilterDisplay: i, GetPageMore: r, GetClassifiedSpecials: u, GetClassifiedAds: f, GenMobileImage: e}
}(jQuery, mbnConf);
$(document).ready(function () {
    function r() {
        n.owlCarousel({
            itemsCustom: [[200, 1], [480, 2], [640, 3], [992, 5]],
            scrollPerPage: !0,
            lazyLoad: !0,
            pagination: !1,
            rewindNav: !0,
            beforeMove: function () {
                var r = n.data("owlCarousel");
                n.nextPage != !1 && n.loading != !0 && (n.pageIndex * n.pageSize >= n.total || (r.itemsAmount == 30 && (n.pageIndex = 1, n.pageSize = 30), n.css("display", "none"), n.pageIndex += 1, mbnListController.GetClassifiedSpecials(t, i, n.pageIndex, n.pageSize).done(function (t) {
                    if (t) {
                        n.loading = !0;
                        n.nextPage == !1;
                        var i = r.maximumItem + r.options.items;
                        r.addItem(t, -1);
                        r.jumpTo(i, !0);
                        n.loading = !1
                    }
                })))
            },
            afterMove: function () {
                var t = n.data("owlCarousel");
                n.nextPage = t.currentItem == t.maximumItem
            }
        })
    }

    var u = $.url(), t = mbnSetting.DistrictCode() > 0 ? mbnSetting.DistrictCode() : mbnSetting.CityCode(),
        i = mbnSetting.CategoryCode() || "", n = $("#owl-carousel-special");
    n.total = mbnSetting.TotalClassifiedSpecial();
    n.pageIndex = 1;
    n.pageSize = 15;
    n.loading = !1;
    n.nextPage = !1;
    n.length > 0 && (r(), $(".mbn-box-slide").css("display", "block"));
    n.total < 1 && ($(".next").css("display", "none"), $(".prev").css("display", "none"));
    $(".next").click(function () {
        n.trigger("owl.next")
    });
    $(".prev").click(function () {
        n.trigger("owl.prev")
    });
    $("#btnNext").click(function () {
        n.trigger("owl.next")
    });
    $("#btnPrev").click(function () {
        n.trigger("owl.prev")
    })
});
mbnList = function (n, t, i, r) {
    var u = function () {
        for (var u, i, g, nt, s, f = n.url(), l = mbnSetting.DistrictCode() > 0 ? mbnSetting.DistrictCode() : mbnSetting.CityCode(), h = mbnSetting.CategorySubCode() || "", w = f.param("kw") || "", a = f.param("min") || 0, v = f.param("max") || 0, it = f.param("cr") || 0, b = mbnSetting.UserId() || "00000000-0000-0000-0000-000000000000", rt = f.param("display") || "", c = f.param("sort") || 0, e = f.param("cp") || 1, y = f.param("img") || 0, k = f.param("time") || 0, tt = f.param("job") || 0, d = n.url().data.seg.path, o = "", p = 0; p < d.length; p++) o += "/" + d[p];
        u = mbnSetting.FilterDisplay();
        i = this;
        i.ShowAds = function (n) {
            return checkShowAds(n)
        };
        i.ClassifiedAds = new mbnClassifiedAds.ClassifiedAds;
        i.TopSearch = new mbnTopSearch.TopSearch;
        i.LocationCookie = new mbnLocationCookie.LocationCookie;
        i.CatCode = ko.observable();
        i.CatCodeUrl = ko.observable();
        i.CityCode = ko.observable();
        i.CityCodeUrl = ko.observable();
        i.IconCat = ko.computed(function () {
            for (var t = mbnResUtils.GetCategories(), n = null, i = 0; i < t.length; i++) if (n = _.findWhere(t[i].c, {co: h}), n != null && n.p > 0) return n = _.findWhere(t, {i: n.p}), n.co;
            if (n == null) return h
        });
        g = function (n) {
            var t = this;
            t.CustomValueFactor = ko.observable();
            t.CustomValueSuffix = ko.observable();
            t.FilterId = ko.observable();
            t.FilterRanges = ko.observableArray();
            t.FilterType = ko.observable();
            t.RangeCode = ko.observable();
            t.Title = ko.observable();
            t.UrlTemplate = ko.observable();
            t.IsCollapse = ko.observable(!1);
            t.IsMore = ko.observable(!1);
            t.IsMoreData = ko.observable(!1);
            t.List = ko.observableArray();
            n != null && (t.CustomValueFactor(n.CustomValueFactor), t.CustomValueSuffix(n.CustomValueSuffix), t.FilterId(n.FilterId), t.FilterRanges(n.FilterRanges), t.FilterType(n.FilterType), t.RangeCode(n.RangeCode), t.Title(n.Title), t.UrlTemplate(n.UrlTemplate), t.IsCollapse(n.IsCollapse == undefined ? !1 : n.IsCollapse), t.IsMore(n.IsMore), t.IsMoreData(n.IsMore), t.List(n.List))
        };
        nt = function (n) {
            var t = this;
            t.FromValue = ko.observable();
            t.Name = ko.observable();
            t.RangeCode = ko.observable();
            t.RangeId = ko.observable();
            t.ToValue = ko.observable();
            n != null && (t.FromValue(n.FromValue), t.Name(n.Name), t.RangeCode(n.RangeCode), t.RangeId(n.RangeId), t.ToValue(n.ToValue))
        };
        i.TotalResult = ko.observable(parseInt(mbnSetting.TotalResult()));
        i.PageSize = ko.observable(parseInt(mbnSetting.PageSize()));
        i.visibleTool = ko.observable(!1);
        i.visibleBtnMore = ko.observable(!0);
        i.TotalRecord = ko.observable();
        i.ShowMobile = ko.observable(!1);
        i.ViewMobile = function () {
            var t = n("#imgViewMobile");
            i.ShowMobile(!0);
            r.GenMobileImage(mbnSetting.UserId()).success(function () {
                var n = new Date, i = t.attr("src");
                t.attr("src", i + n.getMilliseconds().toString());
                t.css("width", "auto");
                t.css("display", "inline")
            })
        };
        i.ImageMobile = ko.computed(function () {
            return "/ViewMobile.ashx?guid=" + mbnSetting.UserId()
        });
        i.DisplayNumResult = function () {
            var h = mbnSetting.DisplayTypeList() || "", f = "",
                o = mbnUtils.StringFormat("Kết quả {0} - {1} trong {2}" + f, 0, 0, 0), n = i.TotalResult() || 0,
                r = i.PageSize() || 0, s = mbnSetting.TotalPagingMax() || 0, u, t;
            e > s && (e = s);
            u = r * (e - 1) + 1;
            t = r * e;
            t = t > n ? n : t;
            u > t && (u = n % r > 0 ? t - n % r : r);
            n > 0 && (o = mbnUtils.StringFormat("Kết quả {0} - {1} trong {2}" + f, mbnUtils.FormatNumber(u, "."), mbnUtils.FormatNumber(t, "."), mbnUtils.FormatNumber(n, ".")), i.visibleTool(!0));
            i.visibleBtnMore(n > r);
            i.TotalRecord(o)
        };
        i.Filters = ko.observableArray();
        i.MoreItems = ko.observableArray();
        i.CreateTool = ko.computed(function () {
            var t = n.url().param();
            delete t.cp;
            i.simpleClick = function () {
                t.display = "simple";
                location.href = o + "?" + n.param(t)
            };
            i.galleryClick = function () {
                t.display = "gallery";
                location.href = o + "?" + n.param(t)
            };
            i.listClick = function () {
                t.display = "list";
                location.href = o + "?" + n.param(t)
            };
            i.listSummaryClick = function () {
                t.display = "summary";
                location.href = o + "?" + n.param(t)
            };
            i.SortValue = ko.observable();
            i.Sorts = ko.observableArray();
            i.Sorts(mbnConst.SortFilter);
            i.SortValue.subscribeChanged(function (i, r) {
                r != undefined && (t.sort = i, location.href = o + "?" + n.param(t))
            });
            i.SortValueResposive = function (i) {
                t.sort = i;
                location.href = o + "?" + n.param(t)
            }
        });
        i.SortDisplayName = ko.observable("Sắp xếp");
        i.SortValueResposiveSelected = ko.observable("icon icon-arrow-up-down");
        s = _.findWhere(mbnConst.SortFilter, {Value: parseInt(c)});
        s != null && s.Value > 0 && (i.SortValueResposiveSelected(s.Icon + " color-selected"), i.SortDisplayName(s.DisplayName));
        i.FilterGoSearch = function (n, t) {
            var u, r, o, c;
            if (mbnSetting.DisplayTypeFilter(null), t == mbnConst.FilterType.DISTRICT) parseInt(n) > 0 ? (r = _.findWhere(i.Districts(), {co: n + ""}), mbnSetting.DistrictFilterCodeUrl(r.u), mbnSetting.DistrictFilterCode(r.co)) : (mbnSetting.DistrictFilterCodeUrl(i.CityCodeUrl()), mbnSetting.DistrictFilterCode(i.CityCode())), u = null, u = mbnResUtils.GetCategoryByCode(h), u != null && (mbnSetting.CategoryFilterCodeUrl(u.url), mbnSetting.CategoryFilterCode(u.co)); else if (t == mbnConst.FilterType.CAT) r = null, o = i.DistrictValue() || 0, o > 0 && i.Districts().length > 0 && (r = _.findWhere(i.Districts(), {co: o})), n == null && (n = {}, n.co = i.CatCode() || "", n.url = i.CatCodeUrl() || ""), r != null ? (mbnSetting.DistrictFilterCodeUrl(r.u), mbnSetting.DistrictFilterCode(r.co)) : (mbnSetting.DistrictFilterCodeUrl(i.CityCodeUrl()), mbnSetting.DistrictFilterCode(l)), mbnSetting.CategoryFilterCodeUrl(n.url), mbnSetting.CategoryFilterCode(n.co); else if (t == mbnConst.FilterType.RANGE) {
                var e = (i.inputFromPrice() || 0) * (i.CustomValueFactor() || 0),
                    f = (i.inputToPrice() || 0) * (i.CustomValueFactor() || 0), s = 0;
                e > f && f > 0 && (s = e, e = f, f = s);
                mbnSetting.MinFilter(e);
                mbnSetting.MaxFilter(f);
                mbnSetting.CustomValueFactor(i.CustomValueFactor())
            } else t == mbnConst.FilterType.IMAGE ? mbnSetting.HasImageFilter(n > 0) : t == mbnConst.FilterType.TIME ? mbnSetting.TimeFilter(n) : t == mbnConst.FilterType.JOBTYPE && mbnSetting.JobTypeFilter(n);
            c = mbnSetting.GenUrlListing();
            location.href = c
        };
        i.CateMake = ko.observable();
        i.UrlTemplate = ko.observable();
        i.CustomValueFactor = ko.observable();
        i.IsShowBoxFilter = ko.observable(!1);
        i.GetFilter = function () {
            var it = function () {
                var n = parseInt(a), t = parseInt(v), r = _.findWhere(i.fromPrices(), {Value: n}),
                    u = _.findWhere(i.toPrices(), {Value: t});
                r != null ? (n = r.Value / i.CustomValueFactor(), i.textFromPrice(mbnUtils.FormatNumber(n, ".")), i.inputFromPrice(n), i.displayFromPrice(!0), i.isSelectedFromPrice(!1), i.visibleResetFromPrice(!0)) : n > 0 && (n = n / i.CustomValueFactor(), i.textFromPrice(mbnUtils.FormatNumber(n, ".")), i.inputFromPrice(n), i.displayFromPrice(!0), i.isSelectedFromPrice(!1), i.visibleResetFromPrice(!0));
                u != null ? (t = u.Value / i.CustomValueFactor(), i.textToPrice(mbnUtils.FormatNumber(t, ".")), i.inputToPrice(t), i.displayToPrice(!0), i.isSelectedToPrice(!1), i.visibleResetToPrice(!0)) : t > 0 && (t = t / i.CustomValueFactor(), i.textToPrice(mbnUtils.FormatNumber(t, ".")), i.inputToPrice(t), i.displayToPrice(!0), i.isSelectedToPrice(!1), i.visibleResetToPrice(!0))
            }, p, rt, e, o, s, r, n, h, d, f;
            if ((i.JobTypeValue = ko.observable(), i.JobTypes = ko.observableArray(), p = mbnResUtils.GetJobType(), n = {}, n.b = 0, n.i = 0, n.n = "Tất cả", p.unshift(n), i.JobTypes(p), i.JobTypeValue.subscribeChanged(function (n, t) {
                    t != undefined && i.FilterGoSearch(n, mbnConst.FilterType.JOBTYPE)
                }), i.TimeValue = ko.observable(), i.Times = ko.observableArray(), i.Times(mbnConst.TimeFilter), i.TimeValue.subscribeChanged(function (n, t) {
                    t != undefined && i.FilterGoSearch(n, mbnConst.FilterType.TIME)
                }), i.ImageValue = ko.observable(), i.Images = ko.observableArray(), i.Images([{
                    Name: "Tất cả tin",
                    Value: 0
                }, {Name: "Chỉ tin có hình", Value: 1}]), i.ImageValue.subscribeChanged(function (n, t) {
                    t != undefined && i.FilterGoSearch(n, mbnConst.FilterType.IMAGE)
                }), i.DistrictValue = ko.observable(), i.Districts = ko.observableArray(), i.DistrictValue.subscribeChanged(function (n, t) {
                    t != undefined && i.FilterGoSearch(n, mbnConst.FilterType.DISTRICT)
                }), i.MakeValue = ko.observable(), i.Makes = ko.observableArray(), i.MakeValue.subscribeChanged(function (n, t) {
                    if (t != undefined) {
                        var r = null;
                        n > 0 && (r = _.findWhere(i.Makes(), {co: n}));
                        i.FilterGoSearch(r, mbnConst.FilterType.CAT)
                    }
                }), i.ModelValue = ko.observable(), i.Models = ko.observableArray(), i.ModelValue.subscribeChanged(function (n, t) {
                    if (t != undefined) {
                        var r = null;
                        r = n > 0 ? _.findWhere(i.Models(), {co: n}) : _.findWhere(i.Makes(), {co: i.CateMake()});
                        i.FilterGoSearch(r, mbnConst.FilterType.CAT)
                    }
                }), b == "00000000-0000-0000-0000-000000000000") && (rt = {}, u != null)) {
                if (e = [], i.CatCode(u.catCode), i.CatCodeUrl(u.catCodeUrl), i.CityCode(u.cityCode), i.CityCodeUrl(u.cityCodeUrl), i.CateMake(u.catMake), e = u.List, e != null) for (o = [], s = 0; s < e.length; s++) if (r = new g(e[s]), n = {}, n.co = 0, n.n = "Tất cả", n.url = "", n.Sort = 0, r.FilterType() == t.Const.FilterType.DISTRICT) i.Districts(mbnResUtils.GetCityByCode(u.cityCode).c), i.Districts.unshift(n), mbnSetting.DistrictCode().length > 0 && i.DistrictValue(l); else if (r.FilterType() == t.Const.FilterType.CAT) i.Makes().length == 0 ? (i.Makes(mbnResUtils.GetCategoryByCode(u.catCode).c), i.Makes.unshift(n), u.catMake != "" && i.MakeValue(u.catMake)) : i.Models().length == 0 && u.catMake.length > 0 && (i.Models(mbnResUtils.GetCategoryByCode(u.catMake).c), i.Models.unshift(n), u.catModel != "" && i.ModelValue(u.catModel)); else if (r.FilterType() == t.Const.FilterType.IMAGE) i.ImageValue(parseInt(y)); else if (r.FilterType() == t.Const.FilterType.TIME) i.TimeValue(parseInt(k)); else if (r.FilterType() == t.Const.FilterType.JOBTYPE) i.JobTypeValue(parseInt(tt)); else if (r.FilterType() != t.Const.FilterType.CAT && r.FilterType() == t.Const.FilterType.RANGE) {
                    for (i.UrlTemplate(r.UrlTemplate()), i.CustomValueFactor(r.CustomValueFactor()), o = [], h = 0; h < r.FilterRanges().length; h++) d = new nt(r.FilterRanges()[h]), n = {}, n.Value = d.FromValue(), n.Name = d.Name(), n.CodeUrl = "", n.Sort = 0, o.push(n);
                    r.List(o);
                    i.fromPrices(r.List());
                    i.toPrices(r.List());
                    it()
                }
                mbnSetting.DistrictFilterCodeUrl(u.districtCodeUrl);
                mbnSetting.DistrictFilterCode(u.districtCode);
                f = null;
                u.catModel.length > 0 ? f = mbnResUtils.GetCategoryByCode(u.catModel) : u.catMake.length > 0 && (f = mbnResUtils.GetCategoryByCode(u.catMake));
                f != null && (mbnSetting.CategoryFilterCodeUrl(f.url), mbnSetting.CategoryFilterCode(f.co));
                mbnSetting.MinFilter(u.min);
                mbnSetting.MaxFilter(u.max);
                mbnSetting.CustomValueFactor(i.CustomValueFactor());
                mbnSetting.SortFilter(c);
                mbnSetting.DisplayTypeFilter(u.displayTypeFilter);
                mbnSetting.KeyWordFilter(w);
                mbnSetting.HasImageFilter(y > 0);
                mbnSetting.TimeFilter(k)
            }
        };
        i.visibleImgWaiting = ko.observable(!1);
        i.clickBtnMore = function () {
            if (!i.visibleImgWaiting()) {
                e++;
                var t = {};
                t.city = l;
                t.cat = h;
                t.kw = w;
                t.min = a;
                t.max = v;
                t.uid = b;
                t.img = y;
                t.sort = c;
                t.cp = e;
                t.pageSize = i.PageSize();
                i.visibleImgWaiting(!0);
                i.visibleBtnMore(!1);
                r.GetPageMore(t).done(function (t) {
                    if (t.Status == !0) {
                        var r = t.Data;
                        n.each(r.List, function () {
                            i.MoreItems.push(this)
                        })
                    }
                    i.visibleBtnMore(r.IsMore);
                    i.visibleImgWaiting(!1)
                }).fail(function () {
                    e--;
                    i.visibleImgWaiting(!1);
                    i.visibleBtnMore(!0)
                })
            }
        };
        i.GetIconServices = function (n) {
            var i = "", t;
            if (n == null) return "";
            for (t in n) n[t] == mbnConst.Services.DISPLAY_TYPE_BITMASK_VIPS ? i = "VIPS" : n[t] == mbnConst.Services.DISPLAY_TYPE_BITMASK_VIP1 || n[t] == mbnConst.Services.DISPLAY_TYPE_BITMASK_SPRH ? i = "VIP1" : n[t] == mbnConst.Services.DISPLAY_TYPE_BITMASK_VIP2 || n[t] == mbnConst.Services.DISPLAY_TYPE_BITMASK_SPRE || n[t] == mbnConst.Services.DISPLAY_TYPE_BITMASK_SPCAR || n[t] == mbnConst.Services.DISPLAY_TYPE_BITMASK_SPJOB ? i = "VIP2" : n[t] == mbnConst.Services.DISPLAY_TYPE_BITMASK_VIP3 ? i = "VIP3" : n[t] == mbnConst.Services.DISPLAY_TYPE_BITMASK_RV && (i = "VIP4");
            return i == "" ? "" : "mbn-label-" + i
        };
        i.CreateToolPrice = function () {
            var t = 0, r = 0, u;
            i.fromPrices = ko.observableArray();
            i.toPrices = ko.observableArray();
            i.textFromPrice = ko.observable("Từ");
            i.displayFromPrice = ko.observable(!0);
            i.isSelectedFromPrice = ko.observable(!1);
            i.inputFromPrice = ko.observable();
            i.inputFromPrice.focused = ko.observable(!1);
            i.visibleResetFromPrice = ko.observable(!1);
            i.textToPrice = ko.observable("Đến");
            i.displayToPrice = ko.observable(!0);
            i.isSelectedToPrice = ko.observable(!1);
            i.inputToPrice = ko.observable();
            i.inputToPrice.focused = ko.observable(!1);
            i.visibleResetToPrice = ko.observable(!1);
            i.selectPrice = function (n, u, f) {
                f == "from" ? (t = 1, i.textFromPrice(n / i.CustomValueFactor()), i.inputFromPrice(n / i.CustomValueFactor()), i.displayFromPrice(!0), i.isSelectedFromPrice(!1), i.visibleResetFromPrice(!0)) : f == "to" && (r = 1, i.textToPrice(n / i.CustomValueFactor()), i.inputToPrice(n / i.CustomValueFactor()), i.displayToPrice(!0), i.isSelectedToPrice(!1), i.visibleResetToPrice(!0));
                i.FilterGoSearch(null, mbnConst.FilterType.RANGE)
            };
            i.OpenPrice = function (n) {
                var t = 0;
                n == "from" ? (t = i.textFromPrice().toString().replace(/\$|\./g, ""), mbnUtils.IsInteger(t) && i.inputFromPrice(t || 0), i.isSelectedFromPrice(!0), i.inputFromPrice.focused(!0), i.displayFromPrice(!1)) : n == "to" && (t = i.textToPrice().toString().replace(/\$|\./g, ""), mbnUtils.IsInteger(t) ? i.inputToPrice(t || 0) : i.inputToPrice(0), i.isSelectedToPrice(!0), i.inputToPrice.focused(!0), i.displayToPrice(!1))
            };
            i.ClearPrice = function (n) {
                n == "from" ? (i.textFromPrice("Từ"), i.inputFromPrice(null), i.visibleResetFromPrice(!1)) : n == "to" && (i.textToPrice("Đến"), i.inputToPrice(null), i.visibleResetToPrice(!1));
                i.FilterGoSearch(null, mbnConst.FilterType.RANGE)
            };
            i.inputFromPrice.focused.subscribe(function (n) {
                var r, u;
                n || (t = 2, r = i.inputFromPrice() || 0, r > 0 ? (u = _.findWhere(i.fromPrices(), {Value: r * i.CustomValueFactor()}), u != null ? i.textFromPrice(u.Value / i.CustomValueFactor()) : i.textFromPrice(mbnUtils.FormatNumber(i.inputFromPrice(), ".")), i.visibleResetFromPrice(!0), r != parseInt(a) / i.CustomValueFactor() && i.FilterGoSearch(null, mbnConst.FilterType.RANGE)) : (i.textFromPrice("Từ"), i.visibleResetFromPrice(!1)))
            });
            i.inputToPrice.focused.subscribe(function (n) {
                var t, u;
                n || (r = 2, t = i.inputToPrice() || 0, t > 0 ? (u = _.findWhere(i.toPrices(), {Value: t * i.CustomValueFactor()}), u != null ? i.textToPrice(u.Value / i.CustomValueFactor()) : i.textToPrice(mbnUtils.FormatNumber(i.inputToPrice(), ".")), i.visibleResetToPrice(!0), t != parseInt(v) / i.CustomValueFactor() && i.FilterGoSearch(null, mbnConst.FilterType.RANGE)) : (i.textToPrice("Đến"), i.visibleResetToPrice(!1)))
            });
            i.ClearFilter = function () {
                mbnSetting.DistrictFilterCodeUrl(null);
                mbnSetting.DistrictFilterCode(null);
                mbnSetting.CategoryFilterCodeUrl(null);
                mbnSetting.CategoryFilterCode(null);
                mbnSetting.MinFilter(null);
                mbnSetting.MaxFilter(null);
                mbnSetting.CustomValueFactor(null);
                mbnSetting.SortFilter(null);
                mbnSetting.KeyWordFilter(null);
                mbnSetting.HasImageFilter(null);
                mbnSetting.TimeFilter(null);
                var n = mbnSetting.GenUrlListing();
                location.href = n
            };
            u = n(document);
            u.click(function () {
                (t > 1 || r > 1) && _.delay(function () {
                    t > 1 && (t = 0, i.displayFromPrice(!0), i.isSelectedFromPrice(!1));
                    r > 1 && (r = 0, i.displayToPrice(!0), i.isSelectedToPrice(!1));
                    return
                }, 200, "Hello")
            })
        };
        i.Activated = function () {
            mbnSetting.HasIconList(!0);
            mbnSetting.HasIconSearch(!1);
            mbnSetting.HasToggleMenu(!1);
            mbnSetting.HasIconSearchReponsive(!0);
            mbnSetting.HasIconSearch(!0);
            mbnSetting.IsListing(!0);
            i.TopSearch.Activated();
            i.SortValue(parseInt(c));
            i.DisplayNumResult();
            i.CreateToolPrice();
            i.GetFilter()
        };
        i.Activated()
    };
    mbnv3.IncludeIn(new u).IsActivated(!0)
}(jQuery, mbnConf, mbnUtils, mbnListController)