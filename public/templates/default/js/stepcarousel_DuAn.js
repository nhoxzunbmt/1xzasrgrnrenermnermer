
var vitriDuAn = 0;
var indexOldDuAn = 0;
var stepcarousel_DuAn = {
    ajaxloadingmsg: '<div style="margin: 1em; font-weight: bold"><img src="ajaxloadr.gif" style="vertical-align: middle" /> Fetching Content. Please wait...</div>', //customize HTML to show while fetching Ajax content
    defaultbuttonsfade: 0.4, //Fade degree for disabled nav buttons (0=completely transparent, 1=completely opaque)
    configholder: {},

    getCSSValue: function (val) { //Returns either 0 (if val contains 'auto') or val as an integer
        return (val == "auto") ? 0 : parseInt(val)
    },

    getremotepanels: function ($, config) { //function to fetch external page containing the panel DIVs
        config.$belt.html(this.ajaxloadingmsg)
        $.ajax({
            url: config.contenttype[1], //path to external content
            async: true,
            error: function (ajaxrequest) {
                config.$belt.html('Error fetching content.<br />Server Response: ' + ajaxrequest.responseText)
            },
            success: function (content) {
                config.$belt.html(content)
                config.$panels = config.$gallery.find('.' + config.panelclass)
                stepcarousel_DuAn.alignpanels($, config)
            }
        })
    },

    getoffset: function (what, offsettype) {
        return (what.offsetParent) ? what[offsettype] + this.getoffset(what.offsetParent, offsettype) : what[offsettype]
    },

    getCookie: function (Name) {
        var re = new RegExp(Name + "=[^;]+", "i"); //construct RE to search for target name/value pair
        if (document.cookie.match(re)) //if cookie found
            return document.cookie.match(re)[0].split("=")[1] //return its value
        return null
    },

    setCookie: function (name, value) {
        document.cookie = name + "=" + value
    },


    fadebuttons: function (config, currentpanel) {
        config.$leftnavbutton.fadeTo('fast', currentpanel == 0 ? this.defaultbuttonsfade : 1)
        config.$rightnavbutton.fadeTo('fast', currentpanel == config.lastvisiblepanel ? this.defaultbuttonsfade : 1)
    },

    addnavbuttons: function (config, currentpanel) {
        config.$leftnavbutton = $('<img src="' + config.defaultbuttons.leftnav[0] + '">').css({ zIndex: 50, position: 'absolute', left: config.offsets.left + config.defaultbuttons.leftnav[1] + 'px', top: config.offsets.top + config.defaultbuttons.leftnav[2] + 'px', cursor: 'hand', cursor: 'pointer' }).attr({ title: 'Back ' + config.defaultbuttons.moveby + ' panels' }).appendTo('body')
        config.$rightnavbutton = $('<img src="' + config.defaultbuttons.rightnav[0] + '">').css({ zIndex: 50, position: 'absolute', left: config.offsets.left + config.$gallery.get(0).offsetWidth + config.defaultbuttons.rightnav[1] + 'px', top: config.offsets.top + config.defaultbuttons.rightnav[2] + 'px', cursor: 'hand', cursor: 'pointer' }).attr({ title: 'Forward ' + config.defaultbuttons.moveby + ' panels' }).appendTo('body')
        config.$leftnavbutton.bind('click', function () { //assign nav button event handlers
            stepcarousel_DuAn.stepBy(config.galleryid, -config.defaultbuttons.moveby, 1)
        })
        config.$rightnavbutton.bind('click', function () { //assign nav button event handlers
            stepcarousel_DuAn.stepBy(config.galleryid, config.defaultbuttons.moveby, 1)
        })
        if (config.panelbehavior.wraparound == false) { //if carousel viewer should stop at first or last panel (instead of wrap back or forth)
            this.fadebuttons(config, currentpanel)
        }
        return config.$leftnavbutton.add(config.$rightnavbutton)
    },

    alignpanels: function ($, config) {
        var paneloffset = 0
        config.paneloffsets = [paneloffset] //array to store upper left offset of each panel (1st element=0)
        config.panelwidths = [] //array to store widths of each panel
        config.$panels.each(function (index) { //loop through panels
            var $currentpanel = $(this)
            $currentpanel.css({ float: 'none', position: 'absolute', left: paneloffset + 'px' }) //position panel
            $currentpanel.bind('click', function (e) { return config.onpanelclick(e.target) }) //bind onpanelclick() to onclick event
            paneloffset += stepcarousel_DuAn.getCSSValue($currentpanel.css('marginRight')) + parseInt($currentpanel.get(0).offsetWidth || $currentpanel.css('width')) //calculate next panel offset
            config.paneloffsets.push(paneloffset) //remember this offset
            config.panelwidths.push(paneloffset - config.paneloffsets[config.paneloffsets.length - 2]) //remember panel width
        })
        config.paneloffsets.pop() //delete last offset (redundant)
        var addpanelwidths = 0
        var lastpanelindex = config.$panels.length - 1
        config.lastvisiblepanel = lastpanelindex
        for (var i = config.$panels.length - 1; i >= 0; i--) {
            addpanelwidths += (i == lastpanelindex ? config.panelwidths[lastpanelindex] : config.paneloffsets[i + 1] - config.paneloffsets[i])
            if (config.gallerywidth > addpanelwidths) {
                config.lastvisiblepanel = i //calculate index of panel that when in 1st position reveals the very last panel all at once based on gallery width
            }
        }
        config.$belt.css({ width: paneloffset + 'px' }) //Set Belt DIV to total panels' widths
        config.currentpanel = (config.panelbehavior.persist) ? parseInt(this.getCookie(window[config.galleryid + "persist"])) : 0 //determine 1st panel to show by default
        config.currentpanel = (typeof config.currentpanel == "number" && config.currentpanel < config.$panels.length) ? config.currentpanel : 0
        if (config.currentpanel != 0) {
            var endpoint = config.paneloffsets[config.currentpanel] + (config.currentpanel == 0 ? 0 : config.beltoffset)
            config.$belt.css({ left: -endpoint + 'px' })
        }
        if (config.defaultbuttons.enable == true) { //if enable default back/forth nav buttons
            var $navbuttons = this.addnavbuttons(config, config.currentpanel)
            $(window).bind("load resize", function () { //refresh position of nav buttons when page loads/resizes, in case offsets weren't available document.oncontentload
                config.offsets = { left: stepcarousel_DuAn.getoffset(config.$gallery.get(0), "offsetLeft"), top: stepcarousel_DuAn.getoffset(config.$gallery.get(0), "offsetTop") }
                config.$leftnavbutton.css({ left: config.offsets.left + config.defaultbuttons.leftnav[1] + 'px', top: config.offsets.top + config.defaultbuttons.leftnav[2] + 'px' })
                config.$rightnavbutton.css({ left: config.offsets.left + config.$gallery.get(0).offsetWidth + config.defaultbuttons.rightnav[1] + 'px', top: config.offsets.top + config.defaultbuttons.rightnav[2] + 'px' })
            })
        }
        if (config.autostep && config.autostep.enable) { //enable auto stepping of Carousel?		

            var $carouselparts = config.$gallery.add(typeof $navbuttons != "undefined" ? $navbuttons : null)
            $carouselparts.bind('click', function () {
                clearTimeout(config.steptimer)
                clearTimeout(config.resumeautostep)
                config.autostep.status = "stopped"
            })
            $carouselparts.hover(function () { //onMouseover
                clearTimeout(config.steptimer)
                clearTimeout(config.resumeautostep)
                config.autostep.hoverstate = "over"
            }, function () { //onMouseout
                if (config.steptimer && config.autostep.hoverstate == "over" && config.autostep.status != "stopped") {
                    config.resumeautostep = setTimeout(function () {
                        stepcarousel_DuAn.autorotate(config.galleryid)
                        config.autostep.hoverstate = "out"
                    }, 500)
                }
            })
            config.steptimer = setTimeout(function () { stepcarousel_DuAn.autorotate(config.galleryid) }, config.autostep.pause) //automatically rotate Carousel Viewer
        } //end enable auto stepping check
        this.statusreport(config.galleryid)
        config.oninit()
        config.onslideaction(this)
    },

    stepTo: function (galleryid, pindex) { /*User entered pindex starts at 1 for intuitiveness. Internally pindex still starts at 0 */

        // alert("stepTo");
        var config = stepcarousel_DuAn.configholder[galleryid]
        if (typeof config == "undefined") {
            alert("There's an error with your set up of Carousel Viewer \"" + galleryid + "\"!")
            return
        }
        var pindex = Math.min(pindex - 1, config.paneloffsets.length - 1)
        var endpoint = config.paneloffsets[pindex] + (pindex == 0 ? 0 : config.beltoffset)
        if (config.panelbehavior.wraparound == false && config.defaultbuttons.enable == true) { //if carousel viewer should stop at first or last panel (instead of wrap back or forth)
            this.fadebuttons(config, pindex)
        }
        config.$belt.animate({ left: -endpoint + 'px' }, config.panelbehavior.speed, function () { config.onslideaction(this) })
        config.currentpanel = pindex
        this.statusreport(galleryid)
    },

    stepBy: function (galleryid, steps, IsAuto) { //isauto if defined indicates stepBy() is being called automatically
        //alert("move");
        var config = stepcarousel_DuAn.configholder[galleryid]
        if (typeof config == "undefined") {
            alert("There's an error with your set up of Carousel Viewer \"" + galleryid + "\"!")
            return
        }
        var direction = (steps > 0) ? 'forward' : 'back' //If "steps" is negative, that means backwards
        var pindex = config.currentpanel + steps //index of panel to stop at
        if (config.panelbehavior.wraparound == false) { //if carousel viewer should stop at first or last panel (instead of wrap back or forth)

            pindex = (direction == "back" && pindex <= 0) ? 0 : (direction == "forward") ? Math.min(pindex, config.lastvisiblepanel) : pindex
            if (config.defaultbuttons.enable == true) { //if default nav buttons are enabled, fade them in and out depending on if at start or end of carousel
                stepcarousel_DuAn.fadebuttons(config, pindex)
            }
        }
        else { //else, for normal stepBy behavior

            if (pindex > config.lastvisiblepanel && direction == "forward") {

                //if destination pindex is greater than last visible panel, yet we're currently not at the end of the carousel yet

                pindex = (config.currentpanel < config.lastvisiblepanel) ? config.lastvisiblepanel : 0

            }
            else if (pindex < 0 && direction == "back") {

                //if destination pindex is less than 0, yet we're currently not at the beginning of the carousel yet
                pindex = (config.currentpanel > 0) ? 0 : config.lastvisiblepanel /*wrap around left*/
            }
        }
        var endpoint = config.paneloffsets[pindex] + (pindex == 0 ? 0 : config.beltoffset) //left distance for Belt DIV to travel to
        if (pindex == 0 && direction == 'forward' || config.currentpanel == 0 && direction == 'back' && config.panelbehavior.wraparound == true) { //decide whether to apply "push pull" effect

            config.$belt.animate({ left: -config.paneloffsets[config.currentpanel] - (direction == 'forward' ? 100 : -30) + 'px' }, 'normal', function () {
                config.$belt.animate({ left: -endpoint + 'px' }, -300000, function () { config.onslideaction(this) })
            })
        }
        else {
            config.$belt.animate({ left: -endpoint + 'px' }, config.panelbehavior.speed, function () { config.onslideaction(this) })
        }

        config.currentpanel = pindex
        this.statusreport(galleryid)

        if (IsAuto == 1) {
            var count = config.TotalBlock;
            vitriDuAn = vitriDuAn + steps;
            //SlideNodeMsgChiTietDaAuto(vitriDuAn, count);
            indexOldDuAn = vitriDuAn;
            //alert("Auto.vitriDuAn=" + vitriDuAn + "indexOldDuAn=" + indexOldDuAn);
            if (vitriDuAn == count) {
                indexOldDuAn = 0;
                vitriDuAn = 0;
                //SlideNodeMsgChiTietDaAuto(vitriDuAn, count);
            }
        }


    },

    autorotate: function (galleryid) {
        var config = stepcarousel_DuAn.configholder[galleryid]
        if (config.$gallery.attr('_ismouseover') != "yes") {
            this.stepBy(galleryid, config.autostep.moveby, 1)
        }
        config.steptimer = setTimeout(function () { stepcarousel_DuAn.autorotate(galleryid) }, config.autostep.pause)
    },

    statusreport: function (galleryid) {
        var config = stepcarousel_DuAn.configholder[galleryid]
        var startpoint = config.currentpanel //index of first visible panel 
        var visiblewidth = 0
        for (var endpoint = startpoint; endpoint < config.paneloffsets.length; endpoint++) { //index (endpoint) of last visible panel
            visiblewidth += config.panelwidths[endpoint]
            if (visiblewidth > config.gallerywidth) {
                break
            }
        }
        startpoint += 1 //format startpoint for user friendiness
        endpoint = (endpoint + 1 == startpoint) ? startpoint : endpoint //If only one image visible on the screen and partially hidden, set endpoint to startpoint
        var valuearray = [startpoint, endpoint, config.panelwidths.length]
        for (var i = 0; i < config.statusvars.length; i++) {
            window[config.statusvars[i]] = valuearray[i] //Define variable (with user specified name) and set to one of the status values
            config.$statusobjs[i].text(valuearray[i] + " ") //Populate element on page with ID="user specified name" with one of the status values
        }
    },

    setup: function (config) {
        //Disable Step Gallery scrollbars ASAP dynamically (enabled for sake of users with JS disabled)
        document.write('<style type="text/css">\n#' + config.galleryid + '{overflow: hidden;}\n</style>')
        jQuery(document).ready(function ($) {
            config.$gallery = $('#' + config.galleryid);
            config.gallerywidth = config.$gallery.width();
            config.offsets = { left: stepcarousel_DuAn.getoffset(config.$gallery.get(0), "offsetLeft"), top: stepcarousel_DuAn.getoffset(config.$gallery.get(0), "offsetTop") }
            config.$belt = config.$gallery.find('.' + config.beltclass) //Find Belt DIV that contains all the panels
            config.$panels = config.$gallery.find('.' + config.panelclass) //Find Panel DIVs that each contain a slide
            config.panelbehavior.wraparound = (config.autostep && config.autostep.enable) ? true : config.panelbehavior.wraparound //if auto step enabled, set "wraparound" to true
            config.onpanelclick = (typeof config.onpanelclick == "undefined") ? function (target) {
            } : config.onpanelclick //attach custom "onpanelclick" event handler
            config.onslideaction = (typeof config.onslide == "undefined") ? function () {
            } : function (beltobj) {
                $(beltobj).stop();
                config.onslide();
            } //attach custom "onslide" event handler
            config.oninit = (typeof config.oninit == "undefined") ? function () {
            } : config.oninit; //attach custom "oninit" event handler
            config.beltoffset = stepcarousel_DuAn.getCSSValue(config.$belt.css('marginLeft')) //Find length of Belt DIV's left margin
            config.statusvars = config.statusvars || [] //get variable names that will hold "start", "end", and "total" slides info
            config.$statusobjs = [$('#' + config.statusvars[0]), $('#' + config.statusvars[1]), $('#' + config.statusvars[2])]
            config.currentpanel = 0;

            stepcarousel_DuAn.configholder[config.galleryid] = config //store config parameter as a variable
            if (config.contenttype[0] == "ajax" && typeof config.contenttype[1] != "undefined") //fetch ajax content?
                stepcarousel_DuAn.getremotepanels($, config);
            else
                stepcarousel_DuAn.alignpanels($, config); //align panels and initialize gallery

            config.TotalBlock = config.TotalBlock;
        }); //end document.ready
        jQuery(window).bind('unload', function () { //clean up
            if (config.panelbehavior.persist) {
                stepcarousel_DuAn.setCookie(window[config.galleryid + "persist"], config.currentpanel)
            }
            jQuery.each(config, function (ai, oi) {
                oi = null;
            });
            config = null;
        });
    }
}

//============= Chi Tiet Du An ==============







var vitriChiTietDa = 0;
var indexOldChiTietDuAn = 0;
var chiTietDaCount;
function SlideNodeMsgChiTietDa(vitri, chiTietDaCount) {
    
    vitriChiTietDa = vitri;
    if (vitriChiTietDa == chiTietDaCount) {
        indexOldChiTietDuAn = 0;
        vitriChiTietDa = 0;
        //SlideNodeMsgChiTietDaAuto(vitri, chiTietDaCount);
    }
    BuildSlideNodeChiTietDa(vitri, chiTietDaCount);

    if (vitriChiTietDa == indexOldChiTietDuAn + 1)
        stepcarousel_ChiTietDuAn.stepByDa('galleryEstateDetail', 1, 0);
    else if (vitriChiTietDa == indexOldChiTietDuAn - 1) {
        stepcarousel_ChiTietDuAn.stepByDa('galleryEstateDetail', -1, 0);
    }
    else {
        stepcarousel_ChiTietDuAn.stepByDa('galleryEstateDetail', vitriChiTietDa - indexOldChiTietDuAn, 0);
    }
    indexOldChiTietDuAn = vitriChiTietDa;
}

function SlideNodeMsgChiTietDaAuto(vitri, chiTietDaCount) {
    
    BuildSlideNodeChiTietDa(vitri, chiTietDaCount);
}

function BuildSlideNodeChiTietDa(vt, chiTietDaCount) {
    var strSlide = "";
    var i;
    for (i = 0; i < chiTietDaCount; i = i + 1) {
        
        if (i == vt)
            strSlide += "<li class=\"current\"><a  href=\"javascript:;\" onclick=\"SlideNodeMsgChiTietDa(" + i + "," + chiTietDaCount + ");\"></a></li>";
        else
            strSlide += "<li><a  href=\"javascript:;\" onclick=\"SlideNodeMsgChiTietDa(" + i + "," + chiTietDaCount + ");\"></a></li>";
      
    }
    $('#imgul').html(strSlide);
}

String.format = function (text) {
    if (arguments.length <= 1) {
        return text;
    }
    var tokenCount = arguments.length - 2;
    for (var token = 0; token <= tokenCount; token++) {
        text = text.replace(new RegExp("\\{" + token + "\\}", "gi"), arguments[token + 1]);
    }
    return text;
};


var stepcarousel_ChiTietDuAn = {
    ajaxloadingmsg: '<div style="margin: 1em; font-weight: bold"><img src="ajaxloadr.gif" style="vertical-align: middle" /> Fetching Content. Please wait...</div>', //customize HTML to show while fetching Ajax content
    defaultbuttonsfade: 0.4, //Fade degree for disabled nav buttons (0=completely transparent, 1=completely opaque)
    configholder: {},

    getCSSValue: function (val) { //Returns either 0 (if val contains 'auto') or val as an integer
        return (val == "auto") ? 0 : parseInt(val)
    },

    getremotepanels: function ($, configDa) { //function to fetch external page containing the panel DIVs
        configDa.$belt.html(this.ajaxloadingmsg)
        $.ajax({
            url: configDa.contenttype[1], //path to external content
            async: true,
            error: function (ajaxrequest) {
                configDa.$belt.html('Error fetching content.<br />Server Response: ' + ajaxrequest.responseText)
            },
            success: function (content) {
                configDa.$belt.html(content)
                configDa.$panels = configDa.$gallery.find('.' + configDa.panelclass)
                stepcarousel_ChiTietDuAn.alignpanels($, configDa)
            }
        })
    },

    getoffset: function (what, offsettype) {
        return (what.offsetParent) ? what[offsettype] + this.getoffset(what.offsetParent, offsettype) : what[offsettype]
    },

    getCookie: function (Name) {
        var re = new RegExp(Name + "=[^;]+", "i"); //construct RE to search for target name/value pair
        if (document.cookie.match(re)) //if cookie found
            return document.cookie.match(re)[0].split("=")[1] //return its value
        return null
    },

    setCookie: function (name, value) {
        document.cookie = name + "=" + value
    },


    fadebuttons: function (configDa, currentpanel) {
        configDa.$leftnavbutton.fadeTo('fast', currentpanel == 0 ? this.defaultbuttonsfade : 1)
        configDa.$rightnavbutton.fadeTo('fast', currentpanel == configDa.lastvisiblepanel ? this.defaultbuttonsfade : 1)
    },

    addnavbuttons: function (configDa, currentpanel) {
        configDa.$leftnavbutton = $('<img src="' + configDa.defaultbuttons.leftnav[0] + '">').css({ zIndex: 50, position: 'absolute', left: configDa.offsets.left + configDa.defaultbuttons.leftnav[1] + 'px', top: configDa.offsets.top + configDa.defaultbuttons.leftnav[2] + 'px', cursor: 'hand', cursor: 'pointer' }).attr({ title: 'Back ' + configDa.defaultbuttons.moveby + ' panels' }).appendTo('body')
        configDa.$rightnavbutton = $('<img src="' + configDa.defaultbuttons.rightnav[0] + '">').css({ zIndex: 50, position: 'absolute', left: configDa.offsets.left + configDa.$gallery.get(0).offsetWidth + configDa.defaultbuttons.rightnav[1] + 'px', top: configDa.offsets.top + configDa.defaultbuttons.rightnav[2] + 'px', cursor: 'hand', cursor: 'pointer' }).attr({ title: 'Forward ' + configDa.defaultbuttons.moveby + ' panels' }).appendTo('body')
        configDa.$leftnavbutton.bind('click', function () { //assign nav button event handlers
            stepcarousel_ChiTietDuAn.stepByDa(configDa.galleryid, -configDa.defaultbuttons.moveby, 1)
        })
        configDa.$rightnavbutton.bind('click', function () { //assign nav button event handlers
            stepcarousel_ChiTietDuAn.stepByDa(configDa.galleryid, configDa.defaultbuttons.moveby, 1)
        })
        if (configDa.panelbehavior.wraparound == false) { //if carousel viewer should stop at first or last panel (instead of wrap back or forth)
            this.fadebuttons(configDa, currentpanel)
        }
        return configDa.$leftnavbutton.add(configDa.$rightnavbutton)
    },

    alignpanels: function ($, configDa) {
        var paneloffset = 0
        configDa.paneloffsets = [paneloffset] //array to store upper left offset of each panel (1st element=0)
        configDa.panelwidths = [] //array to store widths of each panel
        configDa.$panels.each(function (index) { //loop through panels
            var $currentpanel = $(this)
            $currentpanel.css({ float: 'none', position: 'absolute', left: paneloffset + 'px' }) //position panel
            $currentpanel.bind('click', function (e) { return configDa.onpanelclick(e.target) }) //bind onpanelclick() to onclick event
            paneloffset += stepcarousel_ChiTietDuAn.getCSSValue($currentpanel.css('marginRight')) + parseInt($currentpanel.get(0).offsetWidth || $currentpanel.css('width')) //calculate next panel offset
            configDa.paneloffsets.push(paneloffset) //remember this offset
            configDa.panelwidths.push(paneloffset - configDa.paneloffsets[configDa.paneloffsets.length - 2]) //remember panel width
        })
        configDa.paneloffsets.pop() //delete last offset (redundant)
        var addpanelwidths = 0
        var lastpanelindex = configDa.$panels.length - 1
        configDa.lastvisiblepanel = lastpanelindex
        for (var i = configDa.$panels.length - 1; i >= 0; i--) {
            addpanelwidths += (i == lastpanelindex ? configDa.panelwidths[lastpanelindex] : configDa.paneloffsets[i + 1] - configDa.paneloffsets[i])
            if (configDa.gallerywidth > addpanelwidths) {
                configDa.lastvisiblepanel = i //calculate index of panel that when in 1st position reveals the very last panel all at once based on gallery width
            }
        }
        configDa.$belt.css({ width: paneloffset + 'px' }) //Set Belt DIV to total panels' widths
        configDa.currentpanel = (configDa.panelbehavior.persist) ? parseInt(this.getCookie(window[configDa.galleryid + "persist"])) : 0 //determine 1st panel to show by default
        configDa.currentpanel = (typeof configDa.currentpanel == "number" && configDa.currentpanel < configDa.$panels.length) ? configDa.currentpanel : 0
        if (configDa.currentpanel != 0) {
            var endpoint = configDa.paneloffsets[configDa.currentpanel] + (configDa.currentpanel == 0 ? 0 : configDa.beltoffset)
            configDa.$belt.css({ left: -endpoint + 'px' })
        }
        if (configDa.defaultbuttons.enable == true) { //if enable default back/forth nav buttons
            var $navbuttons = this.addnavbuttons(configDa, configDa.currentpanel)
            $(window).bind("load resize", function () { //refresh position of nav buttons when page loads/resizes, in case offsets weren't available document.oncontentload
                configDa.offsets = { left: stepcarousel_ChiTietDuAn.getoffset(configDa.$gallery.get(0), "offsetLeft"), top: stepcarousel_ChiTietDuAn.getoffset(configDa.$gallery.get(0), "offsetTop") }
                configDa.$leftnavbutton.css({ left: configDa.offsets.left + configDa.defaultbuttons.leftnav[1] + 'px', top: configDa.offsets.top + configDa.defaultbuttons.leftnav[2] + 'px' })
                configDa.$rightnavbutton.css({ left: configDa.offsets.left + configDa.$gallery.get(0).offsetWidth + configDa.defaultbuttons.rightnav[1] + 'px', top: configDa.offsets.top + configDa.defaultbuttons.rightnav[2] + 'px' })
            })
        }
        if (configDa.autostep && configDa.autostep.enable) { //enable auto stepping of Carousel?		

            var $carouselparts = configDa.$gallery.add(typeof $navbuttons != "undefined" ? $navbuttons : null)
            $carouselparts.bind('click', function () {
                clearTimeout(configDa.steptimer)
                clearTimeout(configDa.resumeautostep)
                configDa.autostep.status = "stopped"
            })
            $carouselparts.hover(function () { //onMouseover
                clearTimeout(configDa.steptimer)
                clearTimeout(configDa.resumeautostep)
                configDa.autostep.hoverstate = "over"
            }, function () { //onMouseout
                if (configDa.steptimer && configDa.autostep.hoverstate == "over" && configDa.autostep.status != "stopped") {
                    configDa.resumeautostep = setTimeout(function () {
                        stepcarousel_ChiTietDuAn.autorotate(configDa.galleryid)
                        configDa.autostep.hoverstate = "out"
                    }, 500)
                }
            })
            configDa.steptimer = setTimeout(function () { stepcarousel_ChiTietDuAn.autorotate(configDa.galleryid) }, configDa.autostep.pause) //automatically rotate Carousel Viewer
        } //end enable auto stepping check
        this.statusreport(configDa.galleryid)
        configDa.oninit()
        configDa.onslideaction(this)
    },

    stepToDa: function (galleryid, pindex) { /*User entered pindex starts at 1 for intuitiveness. Internally pindex still starts at 0 */

        // alert("stepToDa");
        var configDa = stepcarousel_ChiTietDuAn.configholder[galleryid]
        if (typeof configDa == "undefined") {
            alert("There's an error with your set up of Carousel Viewer \"" + galleryid + "\"!")
            return
        }
        var pindex = Math.min(pindex - 1, configDa.paneloffsets.length - 1)
        var endpoint = configDa.paneloffsets[pindex] + (pindex == 0 ? 0 : configDa.beltoffset)
        if (configDa.panelbehavior.wraparound == false && configDa.defaultbuttons.enable == true) { //if carousel viewer should stop at first or last panel (instead of wrap back or forth)
            this.fadebuttons(configDa, pindex)
        }
        configDa.$belt.animate({ left: -endpoint + 'px' }, configDa.panelbehavior.speed, function () { configDa.onslideaction(this) })
        configDa.currentpanel = pindex
        this.statusreport(galleryid)
    },

    stepByDa: function (galleryid, steps, IsAuto) { //isauto if defined indicates stepByDa() is being called automatically
        //alert(steps);
        var configDa = stepcarousel_ChiTietDuAn.configholder[galleryid]
        if (typeof configDa == "undefined") {
            alert("There's an error with your set up of Carousel Viewer \"" + galleryid + "\"!")
            return
        }
        var direction = (steps > 0) ? 'forward' : 'back' //If "steps" is negative, that means backwards
        var pindex = configDa.currentpanel + steps //index of panel to stop at
        if (configDa.panelbehavior.wraparound == false) { //if carousel viewer should stop at first or last panel (instead of wrap back or forth)

            pindex = (direction == "back" && pindex <= 0) ? 0 : (direction == "forward") ? Math.min(pindex, configDa.lastvisiblepanel) : pindex
            if (configDa.defaultbuttons.enable == true) { //if default nav buttons are enabled, fade them in and out depending on if at start or end of carousel
                stepcarousel_ChiTietDuAn.fadebuttons(configDa, pindex)
            }
        }
        else { //else, for normal stepByDa behavior

            if (pindex > configDa.lastvisiblepanel && direction == "forward") {

                //if destination pindex is greater than last visible panel, yet we're currently not at the end of the carousel yet

                pindex = (configDa.currentpanel < configDa.lastvisiblepanel) ? configDa.lastvisiblepanel : 0

            }
            else if (pindex < 0 && direction == "back") {

                //if destination pindex is less than 0, yet we're currently not at the beginning of the carousel yet
                pindex = (configDa.currentpanel > 0) ? 0 : configDa.lastvisiblepanel /*wrap around left*/
            }
        }
        var endpoint = configDa.paneloffsets[pindex] + (pindex == 0 ? 0 : configDa.beltoffset) //left distance for Belt DIV to travel to
        if (pindex == 0 && direction == 'forward' || configDa.currentpanel == 0 && direction == 'back' && configDa.panelbehavior.wraparound == true) { //decide whether to apply "push pull" effect

            configDa.$belt.animate({ left: -configDa.paneloffsets[configDa.currentpanel] - (direction == 'forward' ? 100 : -30) + 'px' }, 'normal', function () {
                configDa.$belt.animate({ left: -endpoint + 'px' }, -300000, function () { configDa.onslideaction(this) })
            })
        }
        else {
            configDa.$belt.animate({ left: -endpoint + 'px' }, configDa.panelbehavior.speed, function () { configDa.onslideaction(this) })
        }

        configDa.currentpanel = pindex
        this.statusreport(galleryid)

        //if (IsAuto == 1) {

            chiTietDaCount = configDa.TotalBlock;
            if (vitriChiTietDa < chiTietDaCount) {
                vitriChiTietDa = vitriChiTietDa + steps;
                //SlideNodeMsgChiTietDaAuto(vitriChiTietDa, chiTietDaCount);
                indexOldChiTietDuAn = vitriChiTietDa;
            }
            if (vitriChiTietDa == chiTietDaCount) {

                indexOldChiTietDuAn = 0;
                vitriChiTietDa = 0;
                //SlideNodeMsgChiTietDaAuto(vitriChiTietDa, chiTietDaCount);
            }
        //}
        SlideNodeMsgChiTietDaAuto(vitriChiTietDa, chiTietDaCount);


    },

    autorotate: function (galleryid) {
        var configDa = stepcarousel_ChiTietDuAn.configholder[galleryid]
        if (configDa.$gallery.attr('_ismouseover') != "yes") {
            this.stepByDa(galleryid, configDa.autostep.moveby, 1)
        }
        configDa.steptimer = setTimeout(function () { stepcarousel_ChiTietDuAn.autorotate(galleryid) }, configDa.autostep.pause)
    },

    statusreport: function (galleryid) {
        var configDa = stepcarousel_ChiTietDuAn.configholder[galleryid]
        var startpoint = configDa.currentpanel //index of first visible panel 
        var visiblewidth = 0
        for (var endpoint = startpoint; endpoint < configDa.paneloffsets.length; endpoint++) { //index (endpoint) of last visible panel
            visiblewidth += configDa.panelwidths[endpoint]
            if (visiblewidth > configDa.gallerywidth) {
                break
            }
        }
        startpoint += 1 //format startpoint for user friendiness
        endpoint = (endpoint + 1 == startpoint) ? startpoint : endpoint //If only one image visible on the screen and partially hidden, set endpoint to startpoint
        var valuearray = [startpoint, endpoint, configDa.panelwidths.length]
        for (var i = 0; i < configDa.statusvars.length; i++) {
            window[configDa.statusvars[i]] = valuearray[i] //Define variable (with user specified name) and set to one of the status values
            configDa.$statusobjs[i].text(valuearray[i] + " ") //Populate element on page with ID="user specified name" with one of the status values
        }
    },

    setupDa: function (configDa) {
        //Disable Step Gallery scrollbars ASAP dynamically (enabled for sake of users with JS disabled)
        document.write('<style type="text/css">\n#' + configDa.galleryid + '{overflow: hidden;}\n</style>')
        jQuery(document).ready(function ($) {
            configDa.$gallery = $('#' + configDa.galleryid)
            configDa.gallerywidth = configDa.$gallery.width()
            configDa.offsets = { left: stepcarousel_ChiTietDuAn.getoffset(configDa.$gallery.get(0), "offsetLeft"), top: stepcarousel_ChiTietDuAn.getoffset(configDa.$gallery.get(0), "offsetTop") }
            configDa.$belt = configDa.$gallery.find('.' + configDa.beltclass) //Find Belt DIV that contains all the panels
            configDa.$panels = configDa.$gallery.find('.' + configDa.panelclass) //Find Panel DIVs that each contain a slide
            configDa.panelbehavior.wraparound = (configDa.autostep && configDa.autostep.enable) ? true : configDa.panelbehavior.wraparound //if auto step enabled, set "wraparound" to true
            configDa.onpanelclick = (typeof configDa.onpanelclick == "undefined") ? function (target) { } : configDa.onpanelclick //attach custom "onpanelclick" event handler
            configDa.onslideaction = (typeof configDa.onslide == "undefined") ? function () { } : function (beltobj) { $(beltobj).stop(); configDa.onslide() } //attach custom "onslide" event handler
            configDa.oninit = (typeof configDa.oninit == "undefined") ? function () { } : configDa.oninit //attach custom "oninit" event handler
            configDa.beltoffset = stepcarousel_ChiTietDuAn.getCSSValue(configDa.$belt.css('marginLeft')) //Find length of Belt DIV's left margin
            configDa.statusvars = configDa.statusvars || []  //get variable names that will hold "start", "end", and "total" slides info
            configDa.$statusobjs = [$('#' + configDa.statusvars[0]), $('#' + configDa.statusvars[1]), $('#' + configDa.statusvars[2])]
            configDa.currentpanel = 0

            stepcarousel_ChiTietDuAn.configholder[configDa.galleryid] = configDa //store configDa parameter as a variable
            if (configDa.contenttype[0] == "ajax" && typeof configDa.contenttype[1] != "undefined") //fetch ajax content?
                stepcarousel_ChiTietDuAn.getremotepanels($, configDa)
            else
                stepcarousel_ChiTietDuAn.alignpanels($, configDa) //align panels and initialize gallery

            configDa.TotalBlock = configDa.TotalBlock;
        }) //end document.ready
        jQuery(window).bind('unload', function () { //clean up
            if (configDa.panelbehavior.persist) {
                stepcarousel_ChiTietDuAn.setCookie(window[configDa.galleryid + "persist"], configDa.currentpanel)
            }
            jQuery.each(configDa, function (ai, oi) {
                oi = null
            })
            configDa = null
        })
    }
}