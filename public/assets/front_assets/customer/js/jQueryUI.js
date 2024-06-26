;(function($){
    var _remove=$.fn.remove;$.fn.remove=function(){
        $("*",this).add(this).triggerHandler("remove");return _remove.apply(this,arguments);
    };function isVisible(element){
        function checkStyles(element){
            var style=element.style;return(style.display!='none'&&style.visibility!='hidden');
        }
        var visible=checkStyles(element);(visible&&$.each($.dir(element,'parentNode'),function(){
            return(visible=checkStyles(this));
        }));return visible;
    }
    $.extend($.expr[':'],{
        data:function(a,i,m){
            return $.data(a,m[3]);
        },
        tabbable:function(a,i,m){
            var nodeName=a.nodeName.toLowerCase();return(a.tabIndex>=0&&(('a'==nodeName&&a.href)||(/input|select|textarea|button/.test(nodeName)&&'hidden'!=a.type&&!a.disabled))&&isVisible(a));
        }
    });$.keyCode={
        BACKSPACE:8,
        CAPS_LOCK:20,
        COMMA:188,
        CONTROL:17,
        DELETE:46,
        DOWN:40,
        END:35,
        ENTER:13,
        ESCAPE:27,
        HOME:36,
        INSERT:45,
        LEFT:37,
        NUMPAD_ADD:107,
        NUMPAD_DECIMAL:110,
        NUMPAD_DIVIDE:111,
        NUMPAD_ENTER:108,
        NUMPAD_MULTIPLY:106,
        NUMPAD_SUBTRACT:109,
        PAGE_DOWN:34,
        PAGE_UP:33,
        PERIOD:190,
        RIGHT:39,
        SHIFT:16,
        SPACE:32,
        TAB:9,
        UP:38
    };function getter(namespace,plugin,method,args){
        function getMethods(type){
            var methods=$[namespace][plugin][type]||[];return(typeof methods=='string'?methods.split(/,?\s+/):methods);
        }
        var methods=getMethods('getter');if(args.length==1&&typeof args[0]=='string'){
            methods=methods.concat(getMethods('getterSetter'));
        }
        return($.inArray(method,methods)!=-1);
    }
    $.widget=function(name,prototype){
        var namespace=name.split(".")[0];name=name.split(".")[1];$.fn[name]=function(options){
            var isMethodCall=(typeof options=='string'),args=Array.prototype.slice.call(arguments,1);if(isMethodCall&&options.substring(0,1)=='_'){
                return this;
            }
            if(isMethodCall&&getter(namespace,name,options,args)){
                var instance=$.data(this[0],name);return(instance?instance[options].apply(instance,args):undefined);
            }
            return this.each(function(){
                var instance=$.data(this,name);(!instance&&!isMethodCall&&$.data(this,name,new $[namespace][name](this,options)));(instance&&isMethodCall&&$.isFunction(instance[options])&&instance[options].apply(instance,args));
            });
        };$[namespace][name]=function(element,options){
            var self=this;this.widgetName=name;this.widgetEventPrefix=$[namespace][name].eventPrefix||name;this.widgetBaseClass=namespace+'-'+name;this.options=$.extend({},$.widget.defaults,$[namespace][name].defaults,$.metadata&&$.metadata.get(element)[name],options);this.element=$(element).bind('setData.'+name,function(e,key,value){
                return self._setData(key,value);
            }).bind('getData.'+name,function(e,key){
                return self._getData(key);
            }).bind('remove',function(){
                return self.destroy();
            });this._init();
        };$[namespace][name].prototype=$.extend({},$.widget.prototype,prototype);$[namespace][name].getterSetter='option';
    };$.widget.prototype={
        _init:function(){},
        destroy:function(){
            this.element.removeData(this.widgetName);
        },
        option:function(key,value){
            var options=key,self=this;if(typeof key=="string"){
                if(value===undefined){
                    return this._getData(key);
                }
                options={};options[key]=value;
            }
            $.each(options,function(key,value){
                self._setData(key,value);
            });
        },
        _getData:function(key){
            return this.options[key];
        },
        _setData:function(key,value){
            this.options[key]=value;if(key=='disabled'){
                this.element[value?'addClass':'removeClass'](this.widgetBaseClass+'-disabled');
            }
        },
        enable:function(){
            this._setData('disabled',false);
        },
        disable:function(){
            this._setData('disabled',true);
        },
        _trigger:function(type,e,data){
            var eventName=(type==this.widgetEventPrefix?type:this.widgetEventPrefix+type);e=e||$.event.fix({
                type:eventName,
                target:this.element[0]
            });return this.element.triggerHandler(eventName,[e,data],this.options[type]);
        }
    };$.widget.defaults={
        disabled:false
    };$.ui={
        plugin:{
            add:function(module,option,set){
                var proto=$.ui[module].prototype;for(var i in set){
                    proto.plugins[i]=proto.plugins[i]||[];proto.plugins[i].push([option,set[i]]);
                }
            },
            call:function(instance,name,args){
                var set=instance.plugins[name];if(!set){
                    return;
                }
                for(var i=0;i<set.length;i++){
                    if(instance.options[set[i][0]]){
                        set[i][1].apply(instance.element,args);
                    }
                }
            }
        },
        cssCache:{},
        css:function(name){
            if($.ui.cssCache[name]){
                return $.ui.cssCache[name];
            }
            var tmp=$('<div class="ui-gen">').addClass(name).css({
                position:'absolute',
                top:'-5000px',
                left:'-5000px',
                display:'block'
            }).appendTo('body');$.ui.cssCache[name]=!!((!(/auto|default/).test(tmp.css('cursor'))||(/^[1-9]/).test(tmp.css('height'))||(/^[1-9]/).test(tmp.css('width'))||!(/none/).test(tmp.css('backgroundImage'))||!(/transparent|rgba\(0, 0, 0, 0\)/).test(tmp.css('backgroundColor'))));try{
                $('body').get(0).removeChild(tmp.get(0));
            }catch(e){}
            return $.ui.cssCache[name];
        },
        disableSelection:function(el){
            return $(el).attr('unselectable','on').css('MozUserSelect','none').bind('selectstart.ui',function(){
                return false;
            });
        },
        enableSelection:function(el){
            return $(el).attr('unselectable','off').css('MozUserSelect','').unbind('selectstart.ui');
        },
        hasScroll:function(e,a){
            if($(e).css('overflow')=='hidden'){
                return false;
            }
            var scroll=(a&&a=='left')?'scrollLeft':'scrollTop',has=false;if(e[scroll]>0){
                return true;
            }
            e[scroll]=1;has=(e[scroll]>0);e[scroll]=0;return has;
        }
    };$.ui.mouse={
        _mouseInit:function(){
            var self=this;this.element.bind('mousedown.'+this.widgetName,function(e){
                return self._mouseDown(e);
            });if($.browser.msie){
                this._mouseUnselectable=this.element.attr('unselectable');this.element.attr('unselectable','on');
            }
            this.started=false;
        },
        _mouseDestroy:function(){
            this.element.unbind('.'+this.widgetName);($.browser.msie&&this.element.attr('unselectable',this._mouseUnselectable));
        },
        _mouseDown:function(e){
            (this._mouseStarted&&this._mouseUp(e));this._mouseDownEvent=e;var self=this,btnIsLeft=(e.which==1),elIsCancel=(typeof this.options.cancel=="string"?$(e.target).parents().add(e.target).filter(this.options.cancel).length:false);if(!btnIsLeft||elIsCancel||!this._mouseCapture(e)){
                return true;
            }
            this.mouseDelayMet=!this.options.delay;if(!this.mouseDelayMet){
                this._mouseDelayTimer=setTimeout(function(){
                    self.mouseDelayMet=true;
                },this.options.delay);
            }
            if(this._mouseDistanceMet(e)&&this._mouseDelayMet(e)){
                this._mouseStarted=(this._mouseStart(e)!==false);if(!this._mouseStarted){
                    e.preventDefault();return true;
                }
            }
            this._mouseMoveDelegate=function(e){
                return self._mouseMove(e);
            };this._mouseUpDelegate=function(e){
                return self._mouseUp(e);
            };$(document).bind('mousemove.'+this.widgetName,this._mouseMoveDelegate).bind('mouseup.'+this.widgetName,this._mouseUpDelegate);return false;
        },
        _mouseMove:function(e){
            if($.browser.msie&&!e.button){
                return this._mouseUp(e);
            }
            if(this._mouseStarted){
                this._mouseDrag(e);return false;
            }
            if(this._mouseDistanceMet(e)&&this._mouseDelayMet(e)){
                this._mouseStarted=(this._mouseStart(this._mouseDownEvent,e)!==false);(this._mouseStarted?this._mouseDrag(e):this._mouseUp(e));
            }
            return!this._mouseStarted;
        },
        _mouseUp:function(e){
            $(document).unbind('mousemove.'+this.widgetName,this._mouseMoveDelegate).unbind('mouseup.'+this.widgetName,this._mouseUpDelegate);if(this._mouseStarted){
                this._mouseStarted=false;this._mouseStop(e);
            }
            return false;
        },
        _mouseDistanceMet:function(e){
            return(Math.max(Math.abs(this._mouseDownEvent.pageX-e.pageX),Math.abs(this._mouseDownEvent.pageY-e.pageY))>=this.options.distance);
        },
        _mouseDelayMet:function(e){
            return this.mouseDelayMet;
        },
        _mouseStart:function(e){},
        _mouseDrag:function(e){},
        _mouseStop:function(e){},
        _mouseCapture:function(e){
            return true;
        }
    };$.ui.mouse.defaults={
        cancel:null,
        distance:1,
        delay:0
    };
})(jQuery);(function($){
    $.widget("ui.draggable",$.extend({},$.ui.mouse,{
        getHandle:function(e){
            var handle=!this.options.handle||!$(this.options.handle,this.element).length?true:false;$(this.options.handle,this.element).find("*").andSelf().each(function(){
                if(this==e.target)handle=true;
            });return handle;
        },
        createHelper:function(){
            var o=this.options;var helper=$.isFunction(o.helper)?$(o.helper.apply(this.element[0],[e])):(o.helper=='clone'?this.element.clone():this.element);if(!helper.parents('body').length)
                helper.appendTo((o.appendTo=='parent'?this.element[0].parentNode:o.appendTo));if(helper[0]!=this.element[0]&&!(/(fixed|absolute)/).test(helper.css("position")))
                helper.css("position","absolute");return helper;
        },
        _init:function(){
            if(this.options.helper=='original'&&!(/^(?:r|a|f)/).test(this.element.css("position")))
                this.element[0].style.position='relative';(this.options.cssNamespace&&this.element.addClass(this.options.cssNamespace+"-draggable"));(this.options.disabled&&this.element.addClass('ui-draggable-disabled'));this._mouseInit();
        },
        _mouseCapture:function(e){
            var o=this.options;if(this.helper||o.disabled||$(e.target).is('.ui-resizable-handle'))
                return false;this.handle=this.getHandle(e);if(!this.handle)
                return false;return true;
        },
        _mouseStart:function(e){
            var o=this.options;this.helper=this.createHelper();if($.ui.ddmanager)
                $.ui.ddmanager.current=this;this.margins={
                left:(parseInt(this.element.css("marginLeft"),10)||0),
                top:(parseInt(this.element.css("marginTop"),10)||0)
            };this.cssPosition=this.helper.css("position");this.offset=this.element.offset();this.offset={
                top:this.offset.top-this.margins.top,
                left:this.offset.left-this.margins.left
            };this.offset.click={
                left:e.pageX-this.offset.left,
                top:e.pageY-this.offset.top
            };this.cacheScrollParents();this.offsetParent=this.helper.offsetParent();var po=this.offsetParent.offset();if(this.offsetParent[0]==document.body&&$.browser.mozilla)po={
                top:0,
                left:0
            };this.offset.parent={
                top:po.top+(parseInt(this.offsetParent.css("borderTopWidth"),10)||0),
                left:po.left+(parseInt(this.offsetParent.css("borderLeftWidth"),10)||0)
            };if(this.cssPosition=="relative"){
                var p=this.element.position();this.offset.relative={
                    top:p.top-(parseInt(this.helper.css("top"),10)||0)+this.scrollTopParent.scrollTop(),
                    left:p.left-(parseInt(this.helper.css("left"),10)||0)+this.scrollLeftParent.scrollLeft()
                };
            }else{
                this.offset.relative={
                    top:0,
                    left:0
                };
            }
            this.originalPosition=this._generatePosition(e);this.cacheHelperProportions();if(o.cursorAt)
                this.adjustOffsetFromHelper(o.cursorAt);$.extend(this,{
                PAGEY_INCLUDES_SCROLL:(this.cssPosition=="absolute"&&(!this.scrollTopParent[0].tagName||(/(html|body)/i).test(this.scrollTopParent[0].tagName))),
                PAGEX_INCLUDES_SCROLL:(this.cssPosition=="absolute"&&(!this.scrollLeftParent[0].tagName||(/(html|body)/i).test(this.scrollLeftParent[0].tagName))),
                OFFSET_PARENT_NOT_SCROLL_PARENT_Y:this.scrollTopParent[0]!=this.offsetParent[0]&&!(this.scrollTopParent[0]==document&&(/(body|html)/i).test(this.offsetParent[0].tagName)),
                OFFSET_PARENT_NOT_SCROLL_PARENT_X:this.scrollLeftParent[0]!=this.offsetParent[0]&&!(this.scrollLeftParent[0]==document&&(/(body|html)/i).test(this.offsetParent[0].tagName))
            });if(o.containment)
                this.setContainment();this._propagate("start",e);this.cacheHelperProportions();if($.ui.ddmanager&&!o.dropBehaviour)
                $.ui.ddmanager.prepareOffsets(this,e);this.helper.addClass("ui-draggable-dragging");this._mouseDrag(e);return true;
        },
        cacheScrollParents:function(){
            this.scrollTopParent=function(el){
                do{
                    if(/auto|scroll/.test(el.css('overflow'))||(/auto|scroll/).test(el.css('overflow-y')))return el;el=el.parent();
                }while(el[0].parentNode);return $(document);
            }(this.helper);this.scrollLeftParent=function(el){
                do{
                    if(/auto|scroll/.test(el.css('overflow'))||(/auto|scroll/).test(el.css('overflow-x')))return el;el=el.parent();
                }while(el[0].parentNode);return $(document);
            }(this.helper);
        },
        adjustOffsetFromHelper:function(obj){
            if(obj.left!=undefined)this.offset.click.left=obj.left+this.margins.left;if(obj.right!=undefined)this.offset.click.left=this.helperProportions.width-obj.right+this.margins.left;if(obj.top!=undefined)this.offset.click.top=obj.top+this.margins.top;if(obj.bottom!=undefined)this.offset.click.top=this.helperProportions.height-obj.bottom+this.margins.top;
        },
        cacheHelperProportions:function(){
            this.helperProportions={
                width:this.helper.outerWidth(),
                height:this.helper.outerHeight()
            };
        },
        setContainment:function(){
            var o=this.options;if(o.containment=='parent')o.containment=this.helper[0].parentNode;if(o.containment=='document'||o.containment=='window')this.containment=[0-this.offset.relative.left-this.offset.parent.left,0-this.offset.relative.top-this.offset.parent.top,$(o.containment=='document'?document:window).width()-this.offset.relative.left-this.offset.parent.left-this.helperProportions.width-this.margins.left-(parseInt(this.element.css("marginRight"),10)||0),($(o.containment=='document'?document:window).height()||document.body.parentNode.scrollHeight)-this.offset.relative.top-this.offset.parent.top-this.helperProportions.height-this.margins.top-(parseInt(this.element.css("marginBottom"),10)||0)];if(!(/^(document|window|parent)$/).test(o.containment)){
                var ce=$(o.containment)[0];var co=$(o.containment).offset();var over=($(ce).css("overflow")!='hidden');this.containment=[co.left+(parseInt($(ce).css("borderLeftWidth"),10)||0)-this.offset.relative.left-this.offset.parent.left,co.top+(parseInt($(ce).css("borderTopWidth"),10)||0)-this.offset.relative.top-this.offset.parent.top,co.left+(over?Math.max(ce.scrollWidth,ce.offsetWidth):ce.offsetWidth)-(parseInt($(ce).css("borderLeftWidth"),10)||0)-this.offset.relative.left-this.offset.parent.left-this.helperProportions.width-this.margins.left-(parseInt(this.element.css("marginRight"),10)||0),co.top+(over?Math.max(ce.scrollHeight,ce.offsetHeight):ce.offsetHeight)-(parseInt($(ce).css("borderTopWidth"),10)||0)-this.offset.relative.top-this.offset.parent.top-this.helperProportions.height-this.margins.top-(parseInt(this.element.css("marginBottom"),10)||0)];
            }
        },
        _convertPositionTo:function(d,pos){
            if(!pos)pos=this.position;var mod=d=="absolute"?1:-1;return{
                top:(pos.top
                    +this.offset.relative.top*mod
                    +this.offset.parent.top*mod
                    -(this.cssPosition=="fixed"||this.PAGEY_INCLUDES_SCROLL||this.OFFSET_PARENT_NOT_SCROLL_PARENT_Y?0:this.scrollTopParent.scrollTop())*mod
                    +(this.cssPosition=="fixed"?$(document).scrollTop():0)*mod
                    +this.margins.top*mod),
                left:(pos.left
                    +this.offset.relative.left*mod
                    +this.offset.parent.left*mod
                    -(this.cssPosition=="fixed"||this.PAGEX_INCLUDES_SCROLL||this.OFFSET_PARENT_NOT_SCROLL_PARENT_X?0:this.scrollLeftParent.scrollLeft())*mod
                    +(this.cssPosition=="fixed"?$(document).scrollLeft():0)*mod
                    +this.margins.left*mod)
            };
        },
        _generatePosition:function(e){
            var o=this.options;var position={
                top:(e.pageY
                    -this.offset.click.top
                    -this.offset.relative.top
                    -this.offset.parent.top
                    +(this.cssPosition=="fixed"||this.PAGEY_INCLUDES_SCROLL||this.OFFSET_PARENT_NOT_SCROLL_PARENT_Y?0:this.scrollTopParent.scrollTop())
                    -(this.cssPosition=="fixed"?$(document).scrollTop():0)),
                left:(e.pageX
                    -this.offset.click.left
                    -this.offset.relative.left
                    -this.offset.parent.left
                    +(this.cssPosition=="fixed"||this.PAGEX_INCLUDES_SCROLL||this.OFFSET_PARENT_NOT_SCROLL_PARENT_X?0:this.scrollLeftParent.scrollLeft())
                    -(this.cssPosition=="fixed"?$(document).scrollLeft():0))
            };if(!this.originalPosition)return position;if(this.containment){
                if(position.left<this.containment[0])position.left=this.containment[0];if(position.top<this.containment[1])position.top=this.containment[1];if(position.left>this.containment[2])position.left=this.containment[2];if(position.top>this.containment[3])position.top=this.containment[3];
            }
            if(o.grid){
                var top=this.originalPosition.top+Math.round((position.top-this.originalPosition.top)/o.grid[1])*o.grid[1];position.top=this.containment?(!(top<this.containment[1]||top>this.containment[3])?top:(!(top<this.containment[1])?top-o.grid[1]:top+o.grid[1])):top;var left=this.originalPosition.left+Math.round((position.left-this.originalPosition.left)/o.grid[0])*o.grid[0];position.left=this.containment?(!(left<this.containment[0]||left>this.containment[2])?left:(!(left<this.containment[0])?left-o.grid[0]:left+o.grid[0])):left;
            }
            return position;
        },
        _mouseDrag:function(e){
            this.position=this._generatePosition(e);this.positionAbs=this._convertPositionTo("absolute");this.position=this._propagate("drag",e)||this.position;if(!this.options.axis||this.options.axis!="y")this.helper[0].style.left=this.position.left+'px';if(!this.options.axis||this.options.axis!="x")this.helper[0].style.top=this.position.top+'px';if($.ui.ddmanager)$.ui.ddmanager.drag(this,e);return false;
        },
        _mouseStop:function(e){
            var dropped=false;if($.ui.ddmanager&&!this.options.dropBehaviour)
                var dropped=$.ui.ddmanager.drop(this,e);if((this.options.revert=="invalid"&&!dropped)||(this.options.revert=="valid"&&dropped)||this.options.revert===true||($.isFunction(this.options.revert)&&this.options.revert.call(this.element,dropped))){
                var self=this;$(this.helper).animate(this.originalPosition,parseInt(this.options.revertDuration,10)||500,function(){
                    self._propagate("stop",e);self._clear();
                });
            }else{
                this._propagate("stop",e);this._clear();
            }
            return false;
        },
        _clear:function(){
            this.helper.removeClass("ui-draggable-dragging");if(this.options.helper!='original'&&!this.cancelHelperRemoval)this.helper.remove();this.helper=null;this.cancelHelperRemoval=false;
        },
        plugins:{},
        uiHash:function(e){
            return{
                helper:this.helper,
                position:this.position,
                absolutePosition:this.positionAbs,
                options:this.options
            };
        },
        _propagate:function(n,e){
            $.ui.plugin.call(this,n,[e,this.uiHash()]);if(n=="drag")this.positionAbs=this._convertPositionTo("absolute");return this.element.triggerHandler(n=="drag"?n:"drag"+n,[e,this.uiHash()],this.options[n]);
        },
        destroy:function(){
            if(!this.element.data('draggable'))return;this.element.removeData("draggable").unbind(".draggable").removeClass('ui-draggable ui-draggable-dragging ui-draggable-disabled');this._mouseDestroy();
        }
    }));$.extend($.ui.draggable,{
        defaults:{
            appendTo:"parent",
            axis:false,
            cancel:":input",
            delay:0,
            distance:1,
            helper:"original",
            scope:"default",
            cssNamespace:"ui"
        }
    });$.ui.plugin.add("draggable","cursor",{
        start:function(e,ui){
            var t=$('body');if(t.css("cursor"))ui.options._cursor=t.css("cursor");t.css("cursor",ui.options.cursor);
        },
        stop:function(e,ui){
            if(ui.options._cursor)$('body').css("cursor",ui.options._cursor);
        }
    });$.ui.plugin.add("draggable","zIndex",{
        start:function(e,ui){
            var t=$(ui.helper);if(t.css("zIndex"))ui.options._zIndex=t.css("zIndex");t.css('zIndex',ui.options.zIndex);
        },
        stop:function(e,ui){
            if(ui.options._zIndex)$(ui.helper).css('zIndex',ui.options._zIndex);
        }
    });$.ui.plugin.add("draggable","opacity",{
        start:function(e,ui){
            var t=$(ui.helper);if(t.css("opacity"))ui.options._opacity=t.css("opacity");t.css('opacity',ui.options.opacity);
        },
        stop:function(e,ui){
            if(ui.options._opacity)$(ui.helper).css('opacity',ui.options._opacity);
        }
    });$.ui.plugin.add("draggable","iframeFix",{
        start:function(e,ui){
            $(ui.options.iframeFix===true?"iframe":ui.options.iframeFix).each(function(){
                $('<div class="ui-draggable-iframeFix" style="background: #fff;"></div>').css({
                    width:this.offsetWidth+"px",
                    height:this.offsetHeight+"px",
                    position:"absolute",
                    opacity:"0.001",
                    zIndex:1000
                }).css($(this).offset()).appendTo("body");
            });
        },
        stop:function(e,ui){
            $("div.ui-draggable-iframeFix").each(function(){
                this.parentNode.removeChild(this);
            });
        }
    });$.ui.plugin.add("draggable","scroll",{
        start:function(e,ui){
            var o=ui.options;var i=$(this).data("draggable");o.scrollSensitivity=o.scrollSensitivity||20;o.scrollSpeed=o.scrollSpeed||20;i.overflowY=function(el){
                do{
                    if(/auto|scroll/.test(el.css('overflow'))||(/auto|scroll/).test(el.css('overflow-y')))return el;el=el.parent();
                }while(el[0].parentNode);return $(document);
            }(this);i.overflowX=function(el){
                do{
                    if(/auto|scroll/.test(el.css('overflow'))||(/auto|scroll/).test(el.css('overflow-x')))return el;el=el.parent();
                }while(el[0].parentNode);return $(document);
            }(this);if(i.overflowY[0]!=document&&i.overflowY[0].tagName!='HTML')i.overflowYOffset=i.overflowY.offset();if(i.overflowX[0]!=document&&i.overflowX[0].tagName!='HTML')i.overflowXOffset=i.overflowX.offset();
        },
        drag:function(e,ui){
            var o=ui.options,scrolled=false;var i=$(this).data("draggable");if(i.overflowY[0]!=document&&i.overflowY[0].tagName!='HTML'){
                if((i.overflowYOffset.top+i.overflowY[0].offsetHeight)-e.pageY<o.scrollSensitivity)
                    i.overflowY[0].scrollTop=scrolled=i.overflowY[0].scrollTop+o.scrollSpeed;if(e.pageY-i.overflowYOffset.top<o.scrollSensitivity)
                    i.overflowY[0].scrollTop=scrolled=i.overflowY[0].scrollTop-o.scrollSpeed;
            }else{
                if(e.pageY-$(document).scrollTop()<o.scrollSensitivity)
                    scrolled=$(document).scrollTop($(document).scrollTop()-o.scrollSpeed);if($(window).height()-(e.pageY-$(document).scrollTop())<o.scrollSensitivity)
                    scrolled=$(document).scrollTop($(document).scrollTop()+o.scrollSpeed);
            }
            if(i.overflowX[0]!=document&&i.overflowX[0].tagName!='HTML'){
                if((i.overflowXOffset.left+i.overflowX[0].offsetWidth)-e.pageX<o.scrollSensitivity)
                    i.overflowX[0].scrollLeft=scrolled=i.overflowX[0].scrollLeft+o.scrollSpeed;if(e.pageX-i.overflowXOffset.left<o.scrollSensitivity)
                    i.overflowX[0].scrollLeft=scrolled=i.overflowX[0].scrollLeft-o.scrollSpeed;
            }else{
                if(e.pageX-$(document).scrollLeft()<o.scrollSensitivity)
                    scrolled=$(document).scrollLeft($(document).scrollLeft()-o.scrollSpeed);if($(window).width()-(e.pageX-$(document).scrollLeft())<o.scrollSensitivity)
                    scrolled=$(document).scrollLeft($(document).scrollLeft()+o.scrollSpeed);
            }
            if(scrolled!==false)
                $.ui.ddmanager.prepareOffsets(i,e);
        }
    });$.ui.plugin.add("draggable","snap",{
        start:function(e,ui){
            var inst=$(this).data("draggable");inst.snapElements=[];$(ui.options.snap.constructor!=String?(ui.options.snap.items||':data(draggable)'):ui.options.snap).each(function(){
                var $t=$(this);var $o=$t.offset();if(this!=inst.element[0])inst.snapElements.push({
                    item:this,
                    width:$t.outerWidth(),
                    height:$t.outerHeight(),
                    top:$o.top,
                    left:$o.left
                });
            });
        },
        drag:function(e,ui){
            var inst=$(this).data("draggable");var d=ui.options.snapTolerance||20;var x1=ui.absolutePosition.left,x2=x1+inst.helperProportions.width,y1=ui.absolutePosition.top,y2=y1+inst.helperProportions.height;for(var i=inst.snapElements.length-1;i>=0;i--){
                var l=inst.snapElements[i].left,r=l+inst.snapElements[i].width,t=inst.snapElements[i].top,b=t+inst.snapElements[i].height;if(!((l-d<x1&&x1<r+d&&t-d<y1&&y1<b+d)||(l-d<x1&&x1<r+d&&t-d<y2&&y2<b+d)||(l-d<x2&&x2<r+d&&t-d<y1&&y1<b+d)||(l-d<x2&&x2<r+d&&t-d<y2&&y2<b+d))){
                    if(inst.snapElements[i].snapping)(inst.options.snap.release&&inst.options.snap.release.call(inst.element,null,$.extend(inst.uiHash(),{
                        snapItem:inst.snapElements[i].item
                    })));inst.snapElements[i].snapping=false;continue;
                }
                if(ui.options.snapMode!='inner'){
                    var ts=Math.abs(t-y2)<=d;var bs=Math.abs(b-y1)<=d;var ls=Math.abs(l-x2)<=d;var rs=Math.abs(r-x1)<=d;if(ts)ui.position.top=inst._convertPositionTo("relative",{
                        top:t-inst.helperProportions.height,
                        left:0
                    }).top;if(bs)ui.position.top=inst._convertPositionTo("relative",{
                        top:b,
                        left:0
                    }).top;if(ls)ui.position.left=inst._convertPositionTo("relative",{
                        top:0,
                        left:l-inst.helperProportions.width
                    }).left;if(rs)ui.position.left=inst._convertPositionTo("relative",{
                        top:0,
                        left:r
                    }).left;
                }
                var first=(ts||bs||ls||rs);if(ui.options.snapMode!='outer'){
                    var ts=Math.abs(t-y1)<=d;var bs=Math.abs(b-y2)<=d;var ls=Math.abs(l-x1)<=d;var rs=Math.abs(r-x2)<=d;if(ts)ui.position.top=inst._convertPositionTo("relative",{
                        top:t,
                        left:0
                    }).top;if(bs)ui.position.top=inst._convertPositionTo("relative",{
                        top:b-inst.helperProportions.height,
                        left:0
                    }).top;if(ls)ui.position.left=inst._convertPositionTo("relative",{
                        top:0,
                        left:l
                    }).left;if(rs)ui.position.left=inst._convertPositionTo("relative",{
                        top:0,
                        left:r-inst.helperProportions.width
                    }).left;
                }
                if(!inst.snapElements[i].snapping&&(ts||bs||ls||rs||first))
                    (inst.options.snap.snap&&inst.options.snap.snap.call(inst.element,null,$.extend(inst.uiHash(),{
                        snapItem:inst.snapElements[i].item
                    })));inst.snapElements[i].snapping=(ts||bs||ls||rs||first);
            };
        }
    });$.ui.plugin.add("draggable","connectToSortable",{
        start:function(e,ui){
            var inst=$(this).data("draggable");inst.sortables=[];$(ui.options.connectToSortable).each(function(){
                if($.data(this,'sortable')){
                    var sortable=$.data(this,'sortable');inst.sortables.push({
                        instance:sortable,
                        shouldRevert:sortable.options.revert
                    });sortable._refreshItems();sortable._propagate("activate",e,inst);
                }
            });
        },
        stop:function(e,ui){
            var inst=$(this).data("draggable");$.each(inst.sortables,function(){
                if(this.instance.isOver){
                    this.instance.isOver=0;inst.cancelHelperRemoval=true;this.instance.cancelHelperRemoval=false;if(this.shouldRevert)this.instance.options.revert=true;this.instance._mouseStop(e);this.instance.element.triggerHandler("sortreceive",[e,$.extend(this.instance.ui(),{
                        sender:inst.element
                    })],this.instance.options["receive"]);this.instance.options.helper=this.instance.options._helper;
                }else{
                    this.instance._propagate("deactivate",e,inst);
                }
            });
        },
        drag:function(e,ui){
            var inst=$(this).data("draggable"),self=this;var checkPos=function(o){
                var l=o.left,r=l+o.width,t=o.top,b=t+o.height;return(l<(this.positionAbs.left+this.offset.click.left)&&(this.positionAbs.left+this.offset.click.left)<r&&t<(this.positionAbs.top+this.offset.click.top)&&(this.positionAbs.top+this.offset.click.top)<b);
            };$.each(inst.sortables,function(i){
                if(checkPos.call(inst,this.instance.containerCache)){
                    if(!this.instance.isOver){
                        this.instance.isOver=1;this.instance.currentItem=$(self).clone().appendTo(this.instance.element).data("sortable-item",true);this.instance.options._helper=this.instance.options.helper;this.instance.options.helper=function(){
                            return ui.helper[0];
                        };e.target=this.instance.currentItem[0];this.instance._mouseCapture(e,true);this.instance._mouseStart(e,true,true);this.instance.offset.click.top=inst.offset.click.top;this.instance.offset.click.left=inst.offset.click.left;this.instance.offset.parent.left-=inst.offset.parent.left-this.instance.offset.parent.left;this.instance.offset.parent.top-=inst.offset.parent.top-this.instance.offset.parent.top;inst._propagate("toSortable",e);
                    }
                    if(this.instance.currentItem)this.instance._mouseDrag(e);
                }else{
                    if(this.instance.isOver){
                        this.instance.isOver=0;this.instance.cancelHelperRemoval=true;this.instance.options.revert=false;this.instance._mouseStop(e,true);this.instance.options.helper=this.instance.options._helper;this.instance.currentItem.remove();if(this.instance.placeholder)this.instance.placeholder.remove();inst._propagate("fromSortable",e);
                    }
                };
            });
        }
    });$.ui.plugin.add("draggable","stack",{
        start:function(e,ui){
            var group=$.makeArray($(ui.options.stack.group)).sort(function(a,b){
                return(parseInt($(a).css("zIndex"),10)||ui.options.stack.min)-(parseInt($(b).css("zIndex"),10)||ui.options.stack.min);
            });$(group).each(function(i){
                this.style.zIndex=ui.options.stack.min+i;
            });this[0].style.zIndex=ui.options.stack.min+group.length;
        }
    });
})(jQuery);(function($){
    $.widget("ui.droppable",{
        _setData:function(key,value){
            if(key=='accept'){
                this.options.accept=value&&$.isFunction(value)?value:function(d){
                    return d.is(accept);
                };
            }else{
                $.widget.prototype._setData.apply(this,arguments);
            }
        },
        _init:function(){
            var o=this.options,accept=o.accept;this.isover=0;this.isout=1;this.options.accept=this.options.accept&&$.isFunction(this.options.accept)?this.options.accept:function(d){
                return d.is(accept);
            };this.proportions={
                width:this.element[0].offsetWidth,
                height:this.element[0].offsetHeight
            };$.ui.ddmanager.droppables[this.options.scope]=$.ui.ddmanager.droppables[this.options.scope]||[];$.ui.ddmanager.droppables[this.options.scope].push(this);(this.options.cssNamespace&&this.element.addClass(this.options.cssNamespace+"-droppable"));
        },
        plugins:{},
        ui:function(c){
            return{
                draggable:(c.currentItem||c.element),
                helper:c.helper,
                position:c.position,
                absolutePosition:c.positionAbs,
                options:this.options,
                element:this.element
            };
        },
        destroy:function(){
            var drop=$.ui.ddmanager.droppables[this.options.scope];for(var i=0;i<drop.length;i++)
                if(drop[i]==this)
                    drop.splice(i,1);this.element.removeClass("ui-droppable-disabled").removeData("droppable").unbind(".droppable");
        },
        _over:function(e){
            var draggable=$.ui.ddmanager.current;if(!draggable||(draggable.currentItem||draggable.element)[0]==this.element[0])return;if(this.options.accept.call(this.element,(draggable.currentItem||draggable.element))){
                $.ui.plugin.call(this,'over',[e,this.ui(draggable)]);this.element.triggerHandler("dropover",[e,this.ui(draggable)],this.options.over);
            }
        },
        _out:function(e){
            var draggable=$.ui.ddmanager.current;if(!draggable||(draggable.currentItem||draggable.element)[0]==this.element[0])return;if(this.options.accept.call(this.element,(draggable.currentItem||draggable.element))){
                $.ui.plugin.call(this,'out',[e,this.ui(draggable)]);this.element.triggerHandler("dropout",[e,this.ui(draggable)],this.options.out);
            }
        },
        _drop:function(e,custom){
            var draggable=custom||$.ui.ddmanager.current;if(!draggable||(draggable.currentItem||draggable.element)[0]==this.element[0])return false;var childrenIntersection=false;this.element.find(":data(droppable)").not(".ui-draggable-dragging").each(function(){
                var inst=$.data(this,'droppable');if(inst.options.greedy&&$.ui.intersect(draggable,$.extend(inst,{
                    offset:inst.element.offset()
                }),inst.options.tolerance)){
                    childrenIntersection=true;return false;
                }
            });if(childrenIntersection)return false;if(this.options.accept.call(this.element,(draggable.currentItem||draggable.element))){
                $.ui.plugin.call(this,'drop',[e,this.ui(draggable)]);this.element.triggerHandler("drop",[e,this.ui(draggable)],this.options.drop);return this.element;
            }
            return false;
        },
        _activate:function(e){
            var draggable=$.ui.ddmanager.current;$.ui.plugin.call(this,'activate',[e,this.ui(draggable)]);if(draggable)this.element.triggerHandler("dropactivate",[e,this.ui(draggable)],this.options.activate);
        },
        _deactivate:function(e){
            var draggable=$.ui.ddmanager.current;$.ui.plugin.call(this,'deactivate',[e,this.ui(draggable)]);if(draggable)this.element.triggerHandler("dropdeactivate",[e,this.ui(draggable)],this.options.deactivate);
        }
    });$.extend($.ui.droppable,{
        defaults:{
            disabled:false,
            tolerance:'intersect',
            scope:'default',
            cssNamespace:'ui'
        }
    });$.ui.intersect=function(draggable,droppable,toleranceMode){
        if(!droppable.offset)return false;var x1=(draggable.positionAbs||draggable.position.absolute).left,x2=x1+draggable.helperProportions.width,y1=(draggable.positionAbs||draggable.position.absolute).top,y2=y1+draggable.helperProportions.height;var l=droppable.offset.left,r=l+droppable.proportions.width,t=droppable.offset.top,b=t+droppable.proportions.height;switch(toleranceMode){
            case'fit':return(l<x1&&x2<r&&t<y1&&y2<b);break;case'intersect':return(l<x1+(draggable.helperProportions.width/2)&&x2-(draggable.helperProportions.width/2)<r&&t<y1+(draggable.helperProportions.height/2)&&y2-(draggable.helperProportions.height/2)<b);break;case'pointer':return(l<((draggable.positionAbs||draggable.position.absolute).left+(draggable.clickOffset||draggable.offset.click).left)&&((draggable.positionAbs||draggable.position.absolute).left+(draggable.clickOffset||draggable.offset.click).left)<r&&t<((draggable.positionAbs||draggable.position.absolute).top+(draggable.clickOffset||draggable.offset.click).top)&&((draggable.positionAbs||draggable.position.absolute).top+(draggable.clickOffset||draggable.offset.click).top)<b);break;case'touch':return((y1>=t&&y1<=b)||(y2>=t&&y2<=b)||(y1<t&&y2>b))&&((x1>=l&&x1<=r)||(x2>=l&&x2<=r)||(x1<l&&x2>r));break;default:return false;break;
        }
    };$.ui.ddmanager={
        current:null,
        droppables:{
            'default':[]
        },
        prepareOffsets:function(t,e){
            var m=$.ui.ddmanager.droppables[t.options.scope];var type=e?e.type:null;var list=(t.currentItem||t.element).find(":data(droppable)").andSelf();droppablesLoop:for(var i=0;i<m.length;i++){
                if(m[i].options.disabled||(t&&!m[i].options.accept.call(m[i].element,(t.currentItem||t.element))))continue;for(var j=0;j<list.length;j++){
                    if(list[j]==m[i].element[0]){
                        m[i].proportions.height=0;continue droppablesLoop;
                    }
                };m[i].visible=m[i].element.css("display")!="none";if(!m[i].visible)continue;m[i].offset=m[i].element.offset();m[i].proportions={
                    width:m[i].element[0].offsetWidth,
                    height:m[i].element[0].offsetHeight
                };if(type=="dragstart"||type=="sortactivate")m[i]._activate.call(m[i],e);
            }
        },
        drop:function(draggable,e){
            var dropped=false;$.each($.ui.ddmanager.droppables[draggable.options.scope],function(){
                if(!this.options)return;if(!this.options.disabled&&this.visible&&$.ui.intersect(draggable,this,this.options.tolerance))
                    dropped=this._drop.call(this,e);if(!this.options.disabled&&this.visible&&this.options.accept.call(this.element,(draggable.currentItem||draggable.element))){
                    this.isout=1;this.isover=0;this._deactivate.call(this,e);
                }
            });return dropped;
        },
        drag:function(draggable,e){
            if(draggable.options.refreshPositions)$.ui.ddmanager.prepareOffsets(draggable,e);$.each($.ui.ddmanager.droppables[draggable.options.scope],function(){
                if(this.options.disabled||this.greedyChild||!this.visible)return;var intersects=$.ui.intersect(draggable,this,this.options.tolerance);var c=!intersects&&this.isover==1?'isout':(intersects&&this.isover==0?'isover':null);if(!c)return;var parentInstance;if(this.options.greedy){
                    var parent=this.element.parents(':data(droppable):eq(0)');if(parent.length){
                        parentInstance=$.data(parent[0],'droppable');parentInstance.greedyChild=(c=='isover'?1:0);
                    }
                }
                if(parentInstance&&c=='isover'){
                    parentInstance['isover']=0;parentInstance['isout']=1;parentInstance._out.call(parentInstance,e);
                }
                this[c]=1;this[c=='isout'?'isover':'isout']=0;this[c=="isover"?"_over":"_out"].call(this,e);if(parentInstance&&c=='isout'){
                    parentInstance['isout']=0;parentInstance['isover']=1;parentInstance._over.call(parentInstance,e);
                }
            });
        }
    };$.ui.plugin.add("droppable","activeClass",{
        activate:function(e,ui){
            $(this).addClass(ui.options.activeClass);
        },
        deactivate:function(e,ui){
            $(this).removeClass(ui.options.activeClass);
        },
        drop:function(e,ui){
            $(this).removeClass(ui.options.activeClass);
        }
    });$.ui.plugin.add("droppable","hoverClass",{
        over:function(e,ui){
            $(this).addClass(ui.options.hoverClass);
        },
        out:function(e,ui){
            $(this).removeClass(ui.options.hoverClass);
        },
        drop:function(e,ui){
            $(this).removeClass(ui.options.hoverClass);
        }
    });
})(jQuery);(function($){
    $.widget("ui.resizable",$.extend({},$.ui.mouse,{
        _init:function(){
            var self=this,o=this.options;var elpos=this.element.css('position');this.originalElement=this.element;this.element.addClass("ui-resizable").css({
                position:/static/.test(elpos)?'relative':elpos
            });$.extend(o,{
                _aspectRatio:!!(o.aspectRatio),
                helper:o.helper||o.ghost||o.animate?o.helper||'proxy':null,
                knobHandles:o.knobHandles===true?'ui-resizable-knob-handle':o.knobHandles
            });var aBorder='1px solid #DEDEDE';o.defaultTheme={
                'ui-resizable':{
                    display:'block'
                },
                'ui-resizable-handle':{
                    position:'absolute',
                    background:'#F2F2F2',
                    fontSize:'0.1px'
                },
                'ui-resizable-n':{
                    cursor:'n-resize',


                    height:'4px',
                    left:'0px',
                    right:'0px',
                    borderTop:aBorder
                },
                'ui-resizable-s':{
                    cursor:'s-resize',
                    height:'4px',
                    left:'0px',
                    right:'0px',
                    borderBottom:aBorder
                },
                'ui-resizable-e':{
                    cursor:'e-resize',
                    width:'4px',
                    top:'0px',
                    bottom:'0px',
                    borderRight:aBorder
                },
                'ui-resizable-w':{
                    cursor:'w-resize',
                    width:'4px',
                    top:'0px',
                    bottom:'0px',
                    borderLeft:aBorder
                },
                'ui-resizable-se':{
                    cursor:'se-resize',
                    width:'4px',
                    height:'4px',
                    borderRight:aBorder,
                    borderBottom:aBorder
                },
                'ui-resizable-sw':{
                    cursor:'sw-resize',
                    width:'4px',
                    height:'4px',
                    borderBottom:aBorder,
                    borderLeft:aBorder
                },
                'ui-resizable-ne':{
                    cursor:'ne-resize',
                    width:'4px',
                    height:'4px',
                    borderRight:aBorder,
                    borderTop:aBorder
                },
                'ui-resizable-nw':{
                    cursor:'nw-resize',
                    width:'4px',
                    height:'4px',
                    borderLeft:aBorder,
                    borderTop:aBorder
                }
            };o.knobTheme={
                'ui-resizable-handle':{
                    background:'#F2F2F2',
                    border:'1px solid #808080',
                    height:'8px',
                    width:'8px'
                },
                'ui-resizable-n':{
                    cursor:'n-resize',
                    top:'0px',
                    left:'45%'
                },
                'ui-resizable-s':{
                    cursor:'s-resize',
                    bottom:'0px',
                    left:'45%'
                },
                'ui-resizable-e':{
                    cursor:'e-resize',
                    right:'0px',
                    top:'45%'
                },
                'ui-resizable-w':{
                    cursor:'w-resize',
                    left:'0px',
                    top:'45%'
                },
                'ui-resizable-se':{
                    cursor:'se-resize',
                    right:'0px',
                    bottom:'0px'
                },
                'ui-resizable-sw':{
                    cursor:'sw-resize',
                    left:'0px',
                    bottom:'0px'
                },
                'ui-resizable-nw':{
                    cursor:'nw-resize',
                    left:'0px',
                    top:'0px'
                },
                'ui-resizable-ne':{
                    cursor:'ne-resize',
                    right:'0px',
                    top:'0px'
                }
            };o._nodeName=this.element[0].nodeName;if(o._nodeName.match(/canvas|textarea|input|select|button|img/i)){
                var el=this.element;if(/relative/.test(el.css('position'))&&$.browser.opera)
                    el.css({
                        position:'relative',
                        top:'auto',
                        left:'auto'
                    });el.wrap($('<div class="ui-wrapper" style="overflow: hidden;"></div>').css({
                    position:el.css('position'),
                    width:el.outerWidth(),
                    height:el.outerHeight(),
                    top:el.css('top'),
                    left:el.css('left')
                }));var oel=this.element;this.element=this.element.parent();this.element.data('resizable',this);this.element.css({
                    marginLeft:oel.css("marginLeft"),
                    marginTop:oel.css("marginTop"),
                    marginRight:oel.css("marginRight"),
                    marginBottom:oel.css("marginBottom")
                });oel.css({
                    marginLeft:0,
                    marginTop:0,
                    marginRight:0,
                    marginBottom:0
                });if($.browser.safari&&o.preventDefault)oel.css('resize','none');o.proportionallyResize=oel.css({
                    position:'static',
                    zoom:1,
                    display:'block'
                });this.element.css({
                    margin:oel.css('margin')
                });this._proportionallyResize();
            }
            if(!o.handles)o.handles=!$('.ui-resizable-handle',this.element).length?"e,s,se":{
                n:'.ui-resizable-n',
                e:'.ui-resizable-e',
                s:'.ui-resizable-s',
                w:'.ui-resizable-w',
                se:'.ui-resizable-se',
                sw:'.ui-resizable-sw',
                ne:'.ui-resizable-ne',
                nw:'.ui-resizable-nw'
            };if(o.handles.constructor==String){
                o.zIndex=o.zIndex||1000;if(o.handles=='all')o.handles='n,e,s,w,se,sw,ne,nw';var n=o.handles.split(",");o.handles={};var insertionsDefault={
                    handle:'position: absolute; display: none; overflow:hidden;',
                    n:'top: 0pt; width:100%;',
                    e:'right: 0pt; height:100%;',
                    s:'bottom: 0pt; width:100%;',
                    w:'left: 0pt; height:100%;',
                    se:'bottom: 0pt; right: 0px;',
                    sw:'bottom: 0pt; left: 0px;',
                    ne:'top: 0pt; right: 0px;',
                    nw:'top: 0pt; left: 0px;'
                };for(var i=0;i<n.length;i++){
                    var handle=$.trim(n[i]),dt=o.defaultTheme,hname='ui-resizable-'+handle,loadDefault=!$.ui.css(hname)&&!o.knobHandles,userKnobClass=$.ui.css('ui-resizable-knob-handle'),allDefTheme=$.extend(dt[hname],dt['ui-resizable-handle']),allKnobTheme=$.extend(o.knobTheme[hname],!userKnobClass?o.knobTheme['ui-resizable-handle']:{});var applyZIndex=/sw|se|ne|nw/.test(handle)?{
                        zIndex:++o.zIndex
                    }:{};var defCss=(loadDefault?insertionsDefault[handle]:''),axis=$(['<div class="ui-resizable-handle ',hname,'" style="',defCss,insertionsDefault.handle,'"></div>'].join('')).css(applyZIndex);o.handles[handle]='.ui-resizable-'+handle;this.element.append(axis.css(loadDefault?allDefTheme:{}).css(o.knobHandles?allKnobTheme:{}).addClass(o.knobHandles?'ui-resizable-knob-handle':'').addClass(o.knobHandles));
                }
                if(o.knobHandles)this.element.addClass('ui-resizable-knob').css(!$.ui.css('ui-resizable-knob')?{}:{});
            }
            this._renderAxis=function(target){
                target=target||this.element;for(var i in o.handles){
                    if(o.handles[i].constructor==String)
                        o.handles[i]=$(o.handles[i],this.element).show();if(o.transparent)
                        o.handles[i].css({
                            opacity:0
                        });if(this.element.is('.ui-wrapper')&&o._nodeName.match(/textarea|input|select|button/i)){
                        var axis=$(o.handles[i],this.element),padWrapper=0;padWrapper=/sw|ne|nw|se|n|s/.test(i)?axis.outerHeight():axis.outerWidth();var padPos=['padding',/ne|nw|n/.test(i)?'Top':/se|sw|s/.test(i)?'Bottom':/^e$/.test(i)?'Right':'Left'].join("");if(!o.transparent)
                            target.css(padPos,padWrapper);this._proportionallyResize();
                    }
                    if(!$(o.handles[i]).length)continue;
                }
            };this._renderAxis(this.element);o._handles=$('.ui-resizable-handle',self.element);if(o.disableSelection)
                o._handles.each(function(i,e){
                    $.ui.disableSelection(e);
                });o._handles.mouseover(function(){
                if(!o.resizing){
                    if(this.className)
                        var axis=this.className.match(/ui-resizable-(se|sw|ne|nw|n|e|s|w)/i);self.axis=o.axis=axis&&axis[1]?axis[1]:'se';
                }
            });if(o.autoHide){
                o._handles.hide();$(self.element).addClass("ui-resizable-autohide").hover(function(){
                    $(this).removeClass("ui-resizable-autohide");o._handles.show();
                },function(){
                    if(!o.resizing){
                        $(this).addClass("ui-resizable-autohide");o._handles.hide();
                    }
                });
            }
            this._mouseInit();
        },
        plugins:{},
        ui:function(){
            return{
                originalElement:this.originalElement,
                element:this.element,
                helper:this.helper,
                position:this.position,
                size:this.size,
                options:this.options,
                originalSize:this.originalSize,
                originalPosition:this.originalPosition
            };
        },
        _propagate:function(n,e){
            $.ui.plugin.call(this,n,[e,this.ui()]);if(n!="resize")this.element.triggerHandler(["resize",n].join(""),[e,this.ui()],this.options[n]);
        },
        destroy:function(){
            var el=this.element,wrapped=el.children(".ui-resizable").get(0);this._mouseDestroy();var _destroy=function(exp){
                $(exp).removeClass("ui-resizable ui-resizable-disabled").removeData("resizable").unbind(".resizable").find('.ui-resizable-handle').remove();
            };_destroy(el);if(el.is('.ui-wrapper')&&wrapped){
                el.parent().append($(wrapped).css({
                    position:el.css('position'),
                    width:el.outerWidth(),
                    height:el.outerHeight(),
                    top:el.css('top'),
                    left:el.css('left')
                })).end().remove();_destroy(wrapped);
            }
        },
        _mouseCapture:function(e){
            if(this.options.disabled)return false;var handle=false;for(var i in this.options.handles){
                if($(this.options.handles[i])[0]==e.target)handle=true;
            }
            if(!handle)return false;return true;
        },
        _mouseStart:function(e){
            var o=this.options,iniPos=this.element.position(),el=this.element,num=function(v){
                return parseInt(v,10)||0;
            },ie6=$.browser.msie&&$.browser.version<7;o.resizing=true;o.documentScroll={
                top:$(document).scrollTop(),
                left:$(document).scrollLeft()
            };if(el.is('.ui-draggable')||(/absolute/).test(el.css('position'))){
                var sOffset=$.browser.msie&&!o.containment&&(/absolute/).test(el.css('position'))&&!(/relative/).test(el.parent().css('position'));var dscrollt=sOffset?o.documentScroll.top:0,dscrolll=sOffset?o.documentScroll.left:0;el.css({
                    position:'absolute',
                    top:(iniPos.top+dscrollt),
                    left:(iniPos.left+dscrolll)
                });
            }
            if($.browser.opera&&/relative/.test(el.css('position')))
                el.css({
                    position:'relative',
                    top:'auto',
                    left:'auto'
                });this._renderProxy();var curleft=num(this.helper.css('left')),curtop=num(this.helper.css('top'));if(o.containment){
                curleft+=$(o.containment).scrollLeft()||0;curtop+=$(o.containment).scrollTop()||0;
            }
            this.offset=this.helper.offset();this.position={
                left:curleft,
                top:curtop
            };this.size=o.helper||ie6?{
                width:el.outerWidth(),
                height:el.outerHeight()
            }:{
                width:el.width(),
                height:el.height()
            };this.originalSize=o.helper||ie6?{
                width:el.outerWidth(),
                height:el.outerHeight()
            }:{
                width:el.width(),
                height:el.height()
            };this.originalPosition={
                left:curleft,
                top:curtop
            };this.sizeDiff={
                width:el.outerWidth()-el.width(),
                height:el.outerHeight()-el.height()
            };this.originalMousePosition={
                left:e.pageX,
                top:e.pageY
            };o.aspectRatio=(typeof o.aspectRatio=='number')?o.aspectRatio:((this.originalSize.width/this.originalSize.height)||1);if(o.preserveCursor)
                $('body').css('cursor',this.axis+'-resize');this._propagate("start",e);return true;
        },
        _mouseDrag:function(e){
            var el=this.helper,o=this.options,props={},self=this,smp=this.originalMousePosition,a=this.axis;var dx=(e.pageX-smp.left)||0,dy=(e.pageY-smp.top)||0;var trigger=this._change[a];if(!trigger)return false;var data=trigger.apply(this,[e,dx,dy]),ie6=$.browser.msie&&$.browser.version<7,csdif=this.sizeDiff;if(o._aspectRatio||e.shiftKey)
                data=this._updateRatio(data,e);data=this._respectSize(data,e);this._propagate("resize",e);el.css({
                top:this.position.top+"px",
                left:this.position.left+"px",
                width:this.size.width+"px",
                height:this.size.height+"px"
            });if(!o.helper&&o.proportionallyResize)
                this._proportionallyResize();this._updateCache(data);this.element.triggerHandler("resize",[e,this.ui()],this.options["resize"]);return false;
        },
        _mouseStop:function(e){
            this.options.resizing=false;var o=this.options,num=function(v){
                return parseInt(v,10)||0;
            },self=this;if(o.helper){
                var pr=o.proportionallyResize,ista=pr&&(/textarea/i).test(pr.get(0).nodeName),soffseth=ista&&$.ui.hasScroll(pr.get(0),'left')?0:self.sizeDiff.height,soffsetw=ista?0:self.sizeDiff.width;var s={
                    width:(self.size.width-soffsetw),
                    height:(self.size.height-soffseth)
                },left=(parseInt(self.element.css('left'),10)+(self.position.left-self.originalPosition.left))||null,top=(parseInt(self.element.css('top'),10)+(self.position.top-self.originalPosition.top))||null;if(!o.animate)
                    this.element.css($.extend(s,{
                        top:top,
                        left:left
                    }));if(o.helper&&!o.animate)this._proportionallyResize();
            }
            if(o.preserveCursor)
                $('body').css('cursor','auto');this._propagate("stop",e);if(o.helper)this.helper.remove();return false;
        },
        _updateCache:function(data){
            var o=this.options;this.offset=this.helper.offset();if(data.left)this.position.left=data.left;if(data.top)this.position.top=data.top;if(data.height)this.size.height=data.height;if(data.width)this.size.width=data.width;
        },
        _updateRatio:function(data,e){
            var o=this.options,cpos=this.position,csize=this.size,a=this.axis;if(data.height)data.width=(csize.height*o.aspectRatio);else if(data.width)data.height=(csize.width/o.aspectRatio);if(a=='sw'){
                data.left=cpos.left+(csize.width-data.width);data.top=null;
            }
            if(a=='nw'){
                data.top=cpos.top+(csize.height-data.height);data.left=cpos.left+(csize.width-data.width);
            }
            return data;
        },
        _respectSize:function(data,e){
            var el=this.helper,o=this.options,pRatio=o._aspectRatio||e.shiftKey,a=this.axis,ismaxw=data.width&&o.maxWidth&&o.maxWidth<data.width,ismaxh=data.height&&o.maxHeight&&o.maxHeight<data.height,isminw=data.width&&o.minWidth&&o.minWidth>data.width,isminh=data.height&&o.minHeight&&o.minHeight>data.height;if(isminw)data.width=o.minWidth;if(isminh)data.height=o.minHeight;if(ismaxw)data.width=o.maxWidth;if(ismaxh)data.height=o.maxHeight;var dw=this.originalPosition.left+this.originalSize.width,dh=this.position.top+this.size.height;var cw=/sw|nw|w/.test(a),ch=/nw|ne|n/.test(a);if(isminw&&cw)data.left=dw-o.minWidth;if(ismaxw&&cw)data.left=dw-o.maxWidth;if(isminh&&ch)data.top=dh-o.minHeight;if(ismaxh&&ch)data.top=dh-o.maxHeight;var isNotwh=!data.width&&!data.height;if(isNotwh&&!data.left&&data.top)data.top=null;else if(isNotwh&&!data.top&&data.left)data.left=null;return data;
        },
        _proportionallyResize:function(){
            var o=this.options;if(!o.proportionallyResize)return;var prel=o.proportionallyResize,el=this.helper||this.element;if(!o.borderDif){
                var b=[prel.css('borderTopWidth'),prel.css('borderRightWidth'),prel.css('borderBottomWidth'),prel.css('borderLeftWidth')],p=[prel.css('paddingTop'),prel.css('paddingRight'),prel.css('paddingBottom'),prel.css('paddingLeft')];o.borderDif=$.map(b,function(v,i){
                    var border=parseInt(v,10)||0,padding=parseInt(p[i],10)||0;return border+padding;
                });
            }
            prel.css({
                height:(el.height()-o.borderDif[0]-o.borderDif[2])+"px",
                width:(el.width()-o.borderDif[1]-o.borderDif[3])+"px"
            });
        },
        _renderProxy:function(){
            var el=this.element,o=this.options;this.elementOffset=el.offset();if(o.helper){
                this.helper=this.helper||$('<div style="overflow:hidden;"></div>');var ie6=$.browser.msie&&$.browser.version<7,ie6offset=(ie6?1:0),pxyoffset=(ie6?2:-1);this.helper.addClass(o.helper).css({
                    width:el.outerWidth()+pxyoffset,
                    height:el.outerHeight()+pxyoffset,
                    position:'absolute',
                    left:this.elementOffset.left-ie6offset+'px',
                    top:this.elementOffset.top-ie6offset+'px',
                    zIndex:++o.zIndex
                });this.helper.appendTo("body");if(o.disableSelection)
                    $.ui.disableSelection(this.helper.get(0));
            }else{
                this.helper=el;
            }
        },
        _change:{
            e:function(e,dx,dy){
                return{
                    width:this.originalSize.width+dx
                };
            },
            w:function(e,dx,dy){
                var o=this.options,cs=this.originalSize,sp=this.originalPosition;return{
                    left:sp.left+dx,
                    width:cs.width-dx
                };
            },
            n:function(e,dx,dy){
                var o=this.options,cs=this.originalSize,sp=this.originalPosition;return{
                    top:sp.top+dy,
                    height:cs.height-dy
                };
            },
            s:function(e,dx,dy){
                return{
                    height:this.originalSize.height+dy
                };
            },
            se:function(e,dx,dy){
                return $.extend(this._change.s.apply(this,arguments),this._change.e.apply(this,[e,dx,dy]));
            },
            sw:function(e,dx,dy){
                return $.extend(this._change.s.apply(this,arguments),this._change.w.apply(this,[e,dx,dy]));
            },
            ne:function(e,dx,dy){
                return $.extend(this._change.n.apply(this,arguments),this._change.e.apply(this,[e,dx,dy]));
            },
            nw:function(e,dx,dy){
                return $.extend(this._change.n.apply(this,arguments),this._change.w.apply(this,[e,dx,dy]));
            }
        }
    }));$.extend($.ui.resizable,{
        defaults:{
            cancel:":input",
            distance:1,
            delay:0,
            preventDefault:true,
            transparent:false,
            minWidth:10,
            minHeight:10,
            aspectRatio:false,
            disableSelection:true,
            preserveCursor:true,
            autoHide:false,
            knobHandles:false
        }
    });$.ui.plugin.add("resizable","containment",{
        start:function(e,ui){
            var o=ui.options,self=$(this).data("resizable"),el=self.element;var oc=o.containment,ce=(oc instanceof $)?oc.get(0):(/parent/.test(oc))?el.parent().get(0):oc;if(!ce)return;self.containerElement=$(ce);if(/document/.test(oc)||oc==document){
                self.containerOffset={
                    left:0,
                    top:0
                };self.containerPosition={
                    left:0,
                    top:0
                };self.parentData={
                    element:$(document),
                    left:0,
                    top:0,
                    width:$(document).width(),
                    height:$(document).height()||document.body.parentNode.scrollHeight
                };
            }
            else{
                self.containerOffset=$(ce).offset();self.containerPosition=$(ce).position();self.containerSize={
                    height:$(ce).innerHeight(),
                    width:$(ce).innerWidth()
                };var co=self.containerOffset,ch=self.containerSize.height,cw=self.containerSize.width,width=($.ui.hasScroll(ce,"left")?ce.scrollWidth:cw),height=($.ui.hasScroll(ce)?ce.scrollHeight:ch);self.parentData={
                    element:ce,
                    left:co.left,
                    top:co.top,
                    width:width,
                    height:height
                };
            }
        },
        resize:function(e,ui){
            var o=ui.options,self=$(this).data("resizable"),ps=self.containerSize,co=self.containerOffset,cs=self.size,cp=self.position,pRatio=o._aspectRatio||e.shiftKey,cop={
                top:0,
                left:0
            },ce=self.containerElement;if(ce[0]!=document&&/static/.test(ce.css('position')))
                cop=self.containerPosition;if(cp.left<(o.helper?co.left:cop.left)){
                self.size.width=self.size.width+(o.helper?(self.position.left-co.left):(self.position.left-cop.left));if(pRatio)self.size.height=self.size.width/o.aspectRatio;self.position.left=o.helper?co.left:cop.left;
            }
            if(cp.top<(o.helper?co.top:0)){
                self.size.height=self.size.height+(o.helper?(self.position.top-co.top):self.position.top);if(pRatio)self.size.width=self.size.height*o.aspectRatio;self.position.top=o.helper?co.top:0;
            }
            var woset=(o.helper?self.offset.left-co.left:(self.position.left-cop.left))+self.sizeDiff.width,hoset=(o.helper?self.offset.top-co.top:self.position.top)+self.sizeDiff.height;if(woset+self.size.width>=self.parentData.width){
                self.size.width=self.parentData.width-woset;if(pRatio)self.size.height=self.size.width/o.aspectRatio;
            }
            if(hoset+self.size.height>=self.parentData.height){
                self.size.height=self.parentData.height-hoset;if(pRatio)self.size.width=self.size.height*o.aspectRatio;
            }
        },
        stop:function(e,ui){
            var o=ui.options,self=$(this).data("resizable"),cp=self.position,co=self.containerOffset,cop=self.containerPosition,ce=self.containerElement;var helper=$(self.helper),ho=helper.offset(),w=helper.innerWidth(),h=helper.innerHeight();if(o.helper&&!o.animate&&/relative/.test(ce.css('position')))
                $(this).css({
                    left:(ho.left-co.left),
                    top:(ho.top-co.top),
                    width:w,
                    height:h
                });if(o.helper&&!o.animate&&/static/.test(ce.css('position')))
                $(this).css({
                    left:cop.left+(ho.left-co.left),
                    top:cop.top+(ho.top-co.top),
                    width:w,
                    height:h
                });
        }
    });$.ui.plugin.add("resizable","grid",{
        resize:function(e,ui){
            var o=ui.options,self=$(this).data("resizable"),cs=self.size,os=self.originalSize,op=self.originalPosition,a=self.axis,ratio=o._aspectRatio||e.shiftKey;o.grid=typeof o.grid=="number"?[o.grid,o.grid]:o.grid;var ox=Math.round((cs.width-os.width)/(o.grid[0]||1))*(o.grid[0]||1),oy=Math.round((cs.height-os.height)/(o.grid[1]||1))*(o.grid[1]||1);if(/^(se|s|e)$/.test(a)){
                self.size.width=os.width+ox;self.size.height=os.height+oy;
            }
            else if(/^(ne)$/.test(a)){
                self.size.width=os.width+ox;self.size.height=os.height+oy;self.position.top=op.top-oy;
            }
            else if(/^(sw)$/.test(a)){
                self.size.width=os.width+ox;self.size.height=os.height+oy;self.position.left=op.left-ox;
            }
            else{
                self.size.width=os.width+ox;self.size.height=os.height+oy;self.position.top=op.top-oy;self.position.left=op.left-ox;
            }
        }
    });$.ui.plugin.add("resizable","animate",{
        stop:function(e,ui){
            var o=ui.options,self=$(this).data("resizable");var pr=o.proportionallyResize,ista=pr&&(/textarea/i).test(pr.get(0).nodeName),soffseth=ista&&$.ui.hasScroll(pr.get(0),'left')?0:self.sizeDiff.height,soffsetw=ista?0:self.sizeDiff.width;var style={
                width:(self.size.width-soffsetw),
                height:(self.size.height-soffseth)
            },left=(parseInt(self.element.css('left'),10)+(self.position.left-self.originalPosition.left))||null,top=(parseInt(self.element.css('top'),10)+(self.position.top-self.originalPosition.top))||null;self.element.animate($.extend(style,top&&left?{
                top:top,
                left:left
            }:{}),{
                duration:o.animateDuration||"slow",
                easing:o.animateEasing||"swing",
                step:function(){
                    var data={
                        width:parseInt(self.element.css('width'),10),
                        height:parseInt(self.element.css('height'),10),
                        top:parseInt(self.element.css('top'),10),
                        left:parseInt(self.element.css('left'),10)
                    };if(pr)pr.css({
                        width:data.width,
                        height:data.height
                    });self._updateCache(data);self._propagate("animate",e);
                }
            });
        }
    });$.ui.plugin.add("resizable","ghost",{
        start:function(e,ui){
            var o=ui.options,self=$(this).data("resizable"),pr=o.proportionallyResize,cs=self.size;if(!pr)self.ghost=self.element.clone();else self.ghost=pr.clone();self.ghost.css({
                opacity:.25,
                display:'block',
                position:'relative',
                height:cs.height,
                width:cs.width,
                margin:0,
                left:0,
                top:0
            }).addClass('ui-resizable-ghost').addClass(typeof o.ghost=='string'?o.ghost:'');self.ghost.appendTo(self.helper);
        },
        resize:function(e,ui){
            var o=ui.options,self=$(this).data("resizable"),pr=o.proportionallyResize;if(self.ghost)self.ghost.css({
                position:'relative',
                height:self.size.height,
                width:self.size.width
            });
        },
        stop:function(e,ui){
            var o=ui.options,self=$(this).data("resizable"),pr=o.proportionallyResize;if(self.ghost&&self.helper)self.helper.get(0).removeChild(self.ghost.get(0));
        }
    });$.ui.plugin.add("resizable","alsoResize",{
        start:function(e,ui){
            var o=ui.options,self=$(this).data("resizable"),_store=function(exp){
                $(exp).each(function(){
                    $(this).data("resizable-alsoresize",{
                        width:parseInt($(this).width(),10),
                        height:parseInt($(this).height(),10),
                        left:parseInt($(this).css('left'),10),
                        top:parseInt($(this).css('top'),10)
                    });
                });
            };if(typeof(o.alsoResize)=='object'){
                if(o.alsoResize.length){
                    o.alsoResize=o.alsoResize[0];_store(o.alsoResize);
                }
                else{
                    $.each(o.alsoResize,function(exp,c){
                        _store(exp);
                    });
                }
            }else{
                _store(o.alsoResize);
            }
        },
        resize:function(e,ui){
            var o=ui.options,self=$(this).data("resizable"),os=self.originalSize,op=self.originalPosition;var delta={
                height:(self.size.height-os.height)||0,
                width:(self.size.width-os.width)||0,
                top:(self.position.top-op.top)||0,
                left:(self.position.left-op.left)||0
            },_alsoResize=function(exp,c){
                $(exp).each(function(){
                    var start=$(this).data("resizable-alsoresize"),style={},css=c&&c.length?c:['width','height','top','left'];$.each(css||['width','height','top','left'],function(i,prop){
                        var sum=(start[prop]||0)+(delta[prop]||0);if(sum&&sum>=0)
                            style[prop]=sum||null;
                    });$(this).css(style);
                });
            };if(typeof(o.alsoResize)=='object'){
                $.each(o.alsoResize,function(exp,c){
                    _alsoResize(exp,c);
                });
            }else{
                _alsoResize(o.alsoResize);
            }
        },
        stop:function(e,ui){
            $(this).removeData("resizable-alsoresize-start");
        }
    });
})(jQuery);(function($){
    $.widget("ui.selectable",$.extend({},$.ui.mouse,{
        _init:function(){
            var self=this;this.element.addClass("ui-selectable");this.dragged=false;var selectees;this.refresh=function(){
                selectees=$(self.options.filter,self.element[0]);selectees.each(function(){
                    var $this=$(this);var pos=$this.offset();$.data(this,"selectable-item",{
                        element:this,
                        $element:$this,
                        left:pos.left,
                        top:pos.top,
                        right:pos.left+$this.width(),
                        bottom:pos.top+$this.height(),
                        startselected:false,
                        selected:$this.hasClass('ui-selected'),
                        selecting:$this.hasClass('ui-selecting'),
                        unselecting:$this.hasClass('ui-unselecting')
                    });
                });
            };this.refresh();this.selectees=selectees.addClass("ui-selectee");this._mouseInit();this.helper=$(document.createElement('div')).css({
                border:'1px dotted black'
            }).addClass("ui-selectable-helper");
        },
        toggle:function(){
            if(this.options.disabled){
                this.enable();
            }else{
                this.disable();
            }
        },
        destroy:function(){
            this.element.removeClass("ui-selectable ui-selectable-disabled").removeData("selectable").unbind(".selectable");this._mouseDestroy();
        },
        _mouseStart:function(e){
            var self=this;this.opos=[e.pageX,e.pageY];if(this.options.disabled)
                return;var options=this.options;this.selectees=$(options.filter,this.element[0]);this.element.triggerHandler("selectablestart",[e,{
                "selectable":this.element[0],
                "options":options
            }],options.start);$('body').append(this.helper);this.helper.css({
                "z-index":100,
                "position":"absolute",
                "left":e.clientX,
                "top":e.clientY,
                "width":0,
                "height":0
            });if(options.autoRefresh){
                this.refresh();
            }
            this.selectees.filter('.ui-selected').each(function(){
                var selectee=$.data(this,"selectable-item");selectee.startselected=true;if(!e.metaKey){
                    selectee.$element.removeClass('ui-selected');selectee.selected=false;selectee.$element.addClass('ui-unselecting');selectee.unselecting=true;self.element.triggerHandler("selectableunselecting",[e,{
                        selectable:self.element[0],
                        unselecting:selectee.element,
                        options:options
                    }],options.unselecting);
                }
            });var isSelectee=false;$(e.target).parents().andSelf().each(function(){
                if($.data(this,"selectable-item"))isSelectee=true;
            });return this.options.keyboard?!isSelectee:true;
        },
        _mouseDrag:function(e){
            var self=this;this.dragged=true;if(this.options.disabled)
                return;var options=this.options;var x1=this.opos[0],y1=this.opos[1],x2=e.pageX,y2=e.pageY;if(x1>x2){
                var tmp=x2;x2=x1;x1=tmp;
            }
            if(y1>y2){
                var tmp=y2;y2=y1;y1=tmp;
            }
            this.helper.css({
                left:x1,
                top:y1,
                width:x2-x1,
                height:y2-y1
            });this.selectees.each(function(){
                var selectee=$.data(this,"selectable-item");if(!selectee||selectee.element==self.element[0])
                    return;var hit=false;if(options.tolerance=='touch'){
                    hit=(!(selectee.left>x2||selectee.right<x1||selectee.top>y2||selectee.bottom<y1));
                }else if(options.tolerance=='fit'){
                    hit=(selectee.left>x1&&selectee.right<x2&&selectee.top>y1&&selectee.bottom<y2);
                }
                if(hit){
                    if(selectee.selected){
                        selectee.$element.removeClass('ui-selected');selectee.selected=false;
                    }
                    if(selectee.unselecting){
                        selectee.$element.removeClass('ui-unselecting');selectee.unselecting=false;
                    }
                    if(!selectee.selecting){
                        selectee.$element.addClass('ui-selecting');selectee.selecting=true;self.element.triggerHandler("selectableselecting",[e,{
                            selectable:self.element[0],
                            selecting:selectee.element,
                            options:options
                        }],options.selecting);
                    }
                }else{
                    if(selectee.selecting){
                        if(e.metaKey&&selectee.startselected){
                            selectee.$element.removeClass('ui-selecting');selectee.selecting=false;selectee.$element.addClass('ui-selected');selectee.selected=true;
                        }else{
                            selectee.$element.removeClass('ui-selecting');selectee.selecting=false;if(selectee.startselected){
                                selectee.$element.addClass('ui-unselecting');selectee.unselecting=true;
                            }
                            self.element.triggerHandler("selectableunselecting",[e,{
                                selectable:self.element[0],
                                unselecting:selectee.element,
                                options:options
                            }],options.unselecting);
                        }
                    }
                    if(selectee.selected){
                        if(!e.metaKey&&!selectee.startselected){
                            selectee.$element.removeClass('ui-selected');selectee.selected=false;selectee.$element.addClass('ui-unselecting');selectee.unselecting=true;self.element.triggerHandler("selectableunselecting",[e,{
                                selectable:self.element[0],
                                unselecting:selectee.element,
                                options:options
                            }],options.unselecting);
                        }
                    }
                }
            });return false;
        },
        _mouseStop:function(e){
            var self=this;this.dragged=false;var options=this.options;$('.ui-unselecting',this.element[0]).each(function(){
                var selectee=$.data(this,"selectable-item");selectee.$element.removeClass('ui-unselecting');selectee.unselecting=false;selectee.startselected=false;self.element.triggerHandler("selectableunselected",[e,{
                    selectable:self.element[0],
                    unselected:selectee.element,
                    options:options
                }],options.unselected);
            });$('.ui-selecting',this.element[0]).each(function(){
                var selectee=$.data(this,"selectable-item");selectee.$element.removeClass('ui-selecting').addClass('ui-selected');selectee.selecting=false;selectee.selected=true;selectee.startselected=true;self.element.triggerHandler("selectableselected",[e,{
                    selectable:self.element[0],
                    selected:selectee.element,
                    options:options
                }],options.selected);
            });this.element.triggerHandler("selectablestop",[e,{
                selectable:self.element[0],
                options:this.options
            }],this.options.stop);this.helper.remove();return false;
        }
    }));$.extend($.ui.selectable,{
        defaults:{
            distance:1,
            delay:0,
            cancel:":input",
            appendTo:'body',
            autoRefresh:true,
            filter:'*',
            tolerance:'touch'
        }
    });
})(jQuery);(function($){
    function contains(a,b){
        var safari2=$.browser.safari&&$.browser.version<522;if(a.contains&&!safari2){
            return a.contains(b);
        }
        if(a.compareDocumentPosition)
            return!!(a.compareDocumentPosition(b)&16);while(b=b.parentNode)
            if(b==a)return true;return false;
    };$.widget("ui.sortable",$.extend({},$.ui.mouse,{
        _init:function(){
            var o=this.options;this.containerCache={};this.element.addClass("ui-sortable");this.refresh();this.floating=this.items.length?(/left|right/).test(this.items[0].item.css('float')):false;this.offset=this.element.offset();this._mouseInit();
        },
        plugins:{},
        ui:function(inst){
            return{
                helper:(inst||this)["helper"],
                placeholder:(inst||this)["placeholder"]||$([]),
                position:(inst||this)["position"],
                absolutePosition:(inst||this)["positionAbs"],
                options:this.options,
                element:this.element,
                item:(inst||this)["currentItem"],
                sender:inst?inst.element:null
            };
        },
        _propagate:function(n,e,inst,noPropagation){
            $.ui.plugin.call(this,n,[e,this.ui(inst)]);if(!noPropagation)this.element.triggerHandler(n=="sort"?n:"sort"+n,[e,this.ui(inst)],this.options[n]);
        },
        serialize:function(o){
            var items=this._getItemsAsjQuery(o&&o.connected);var str=[];o=o||{};$(items).each(function(){
                var res=($(this.item||this).attr(o.attribute||'id')||'').match(o.expression||(/(.+)[-=_](.+)/));if(res)str.push((o.key||res[1]+'[]')+'='+(o.key&&o.expression?res[1]:res[2]));
                });return str.join('&');
            },
            toArray:function(o){
                var items=this._getItemsAsjQuery(o&&o.connected);var ret=[];items.each(function(){
                    ret.push($(this).attr(o.attr||'id'));
                });return ret;
            },
            _intersectsWith:function(item){
                var x1=this.positionAbs.left,x2=x1+this.helperProportions.width,y1=this.positionAbs.top,y2=y1+this.helperProportions.height;var l=item.left,r=l+item.width,t=item.top,b=t+item.height;var dyClick=this.offset.click.top,dxClick=this.offset.click.left;var isOverElement=(y1+dyClick)>t&&(y1+dyClick)<b&&(x1+dxClick)>l&&(x1+dxClick)<r;if(this.options.tolerance=="pointer"||this.options.forcePointerForContainers||(this.options.tolerance=="guess"&&this.helperProportions[this.floating?'width':'height']>item[this.floating?'width':'height'])){
                    return isOverElement;
                }else{
                    return(l<x1+(this.helperProportions.width/2)&&x2-(this.helperProportions.width/2)<r&&t<y1+(this.helperProportions.height/2)&&y2-(this.helperProportions.height/2)<b);
                }
            },
            _intersectsWithEdge:function(item){
                var x1=this.positionAbs.left,x2=x1+this.helperProportions.width,y1=this.positionAbs.top,y2=y1+this.helperProportions.height;var l=item.left,r=l+item.width,t=item.top,b=t+item.height;var dyClick=this.offset.click.top,dxClick=this.offset.click.left;var isOverElement=(y1+dyClick)>t&&(y1+dyClick)<b&&(x1+dxClick)>l&&(x1+dxClick)<r;if(this.options.tolerance=="pointer"||(this.options.tolerance=="guess"&&this.helperProportions[this.floating?'width':'height']>item[this.floating?'width':'height'])){
                    if(!isOverElement)return false;if(this.floating){
                        if((x1+dxClick)>l&&(x1+dxClick)<l+item.width/2)return 2;if((x1+dxClick)>l+item.width/2&&(x1+dxClick)<r)return 1;
                    }else{
                        var height=item.height;var direction=y1-this.updateOriginalPosition.top<0?2:1;if(direction==1&&(y1+dyClick)<t+height/2){
                            return 2;
                        }
                        else if(direction==2&&(y1+dyClick)>t+height/2){
                            return 1;
                        }
                    }
                }else{
                    if(!(l<x1+(this.helperProportions.width/2)&&x2-(this.helperProportions.width/2)<r&&t<y1+(this.helperProportions.height/2)&&y2-(this.helperProportions.height/2)<b))return false;if(this.floating){
                        if(x2>l&&x1<l)return 2;if(x1<r&&x2>r)return 1;
                    }else{
                        if(y2>t&&y1<t)return 1;if(y1<b&&y2>b)return 2;
                    }
                }
                return false;
            },
            refresh:function(){
                this._refreshItems();this.refreshPositions();
            },
            _getItemsAsjQuery:function(connected){
                var self=this;var items=[];var queries=[];if(this.options.connectWith&&connected){
                    for(var i=this.options.connectWith.length-1;i>=0;i--){
                        var cur=$(this.options.connectWith[i]);for(var j=cur.length-1;j>=0;j--){
                            var inst=$.data(cur[j],'sortable');if(inst&&inst!=this&&!inst.options.disabled){
                                queries.push([$.isFunction(inst.options.items)?inst.options.items.call(inst.element):$(inst.options.items,inst.element).not(".ui-sortable-helper"),inst]);
                            }
                        };
                    };
                }
                queries.push([$.isFunction(this.options.items)?this.options.items.call(this.element,null,{
                    options:this.options,
                    item:this.currentItem
                }):$(this.options.items,this.element).not(".ui-sortable-helper"),this]);for(var i=queries.length-1;i>=0;i--){
                    queries[i][0].each(function(){
                        items.push(this);
                    });
                };return $(items);
            },
            _removeCurrentsFromItems:function(){
                var list=this.currentItem.find(":data(sortable-item)");for(var i=0;i<this.items.length;i++){
                    for(var j=0;j<list.length;j++){
                        if(list[j]==this.items[i].item[0])
                            this.items.splice(i,1);
                    };
                };
            },
            _refreshItems:function(){
                this.items=[];this.containers=[this];var items=this.items;var self=this;var queries=[[$.isFunction(this.options.items)?this.options.items.call(this.element,null,{
                    options:this.options,
                    item:this.currentItem
                }):$(this.options.items,this.element),this]];if(this.options.connectWith){
                    for(var i=this.options.connectWith.length-1;i>=0;i--){
                        var cur=$(this.options.connectWith[i]);for(var j=cur.length-1;j>=0;j--){
                            var inst=$.data(cur[j],'sortable');if(inst&&inst!=this&&!inst.options.disabled){
                                queries.push([$.isFunction(inst.options.items)?inst.options.items.call(inst.element):$(inst.options.items,inst.element),inst]);this.containers.push(inst);
                            }
                        };
                    };
                }
                for(var i=queries.length-1;i>=0;i--){
                    queries[i][0].each(function(){
                        $.data(this,'sortable-item',queries[i][1]);items.push({
                            item:$(this),
                            instance:queries[i][1],
                            width:0,
                            height:0,
                            left:0,
                            top:0
                        });
                    });
                };
            },
            refreshPositions:function(fast){
                if(this.offsetParent){
                    var po=this.offsetParent.offset();this.offset.parent={
                        top:po.top+this.offsetParentBorders.top,
                        left:po.left+this.offsetParentBorders.left
                    };
                }
                for(var i=this.items.length-1;i>=0;i--){
                    if(this.items[i].instance!=this.currentContainer&&this.currentContainer&&this.items[i].item[0]!=this.currentItem[0])
                        continue;var t=this.options.toleranceElement?$(this.options.toleranceElement,this.items[i].item):this.items[i].item;if(!fast){
                        this.items[i].width=t[0].offsetWidth;this.items[i].height=t[0].offsetHeight;
                    }
                    var p=t.offset();this.items[i].left=p.left;this.items[i].top=p.top;
                };if(this.options.custom&&this.options.custom.refreshContainers){
                    this.options.custom.refreshContainers.call(this);
                }else{
                    for(var i=this.containers.length-1;i>=0;i--){
                        var p=this.containers[i].element.offset();this.containers[i].containerCache.left=p.left;this.containers[i].containerCache.top=p.top;this.containers[i].containerCache.width=this.containers[i].element.outerWidth();this.containers[i].containerCache.height=this.containers[i].element.outerHeight();
                    };
                }
            },
            destroy:function(){
                this.element.removeClass("ui-sortable ui-sortable-disabled").removeData("sortable").unbind(".sortable");this._mouseDestroy();for(var i=this.items.length-1;i>=0;i--)
                    this.items[i].item.removeData("sortable-item");
            },
            _createPlaceholder:function(that){
                var self=that||this,o=self.options;if(!o.placeholder||o.placeholder.constructor==String){
                    var className=o.placeholder;o.placeholder={
                        element:function(){
                            var el=$(document.createElement(self.currentItem[0].nodeName)).addClass(className||"ui-sortable-placeholder")[0];if(!className){
                                el.style.visibility="hidden";document.body.appendChild(el);el.innerHTML=self.currentItem[0].innerHTML;document.body.removeChild(el);
                            };return el;
                        },
                        update:function(container,p){
                            if(className&&!o.forcePlaceholderSize)return;if(!p.height()){
                                p.height(self.currentItem.innerHeight()-parseInt(self.currentItem.css('paddingTop')||0,10)-parseInt(self.currentItem.css('paddingBottom')||0,10));
                            };if(!p.width()){
                                p.width(self.currentItem.innerWidth()-parseInt(self.currentItem.css('paddingLeft')||0,10)-parseInt(self.currentItem.css('paddingRight')||0,10));
                            };
                        }
                    };
                }
                self.placeholder=$(o.placeholder.element.call(self.element,self.currentItem))
                self.currentItem.parent()[0].appendChild(self.placeholder[0]);self.placeholder[0].parentNode.insertBefore(self.placeholder[0],self.currentItem[0]);o.placeholder.update(self,self.placeholder);
            },
            _contactContainers:function(e){
                for(var i=this.containers.length-1;i>=0;i--){
                    if(this._intersectsWith(this.containers[i].containerCache)){
                        if(!this.containers[i].containerCache.over){
                            if(this.currentContainer!=this.containers[i]){
                                var dist=10000;var itemWithLeastDistance=null;var base=this.positionAbs[this.containers[i].floating?'left':'top'];for(var j=this.items.length-1;j>=0;j--){
                                    if(!contains(this.containers[i].element[0],this.items[j].item[0]))continue;var cur=this.items[j][this.containers[i].floating?'left':'top'];if(Math.abs(cur-base)<dist){
                                        dist=Math.abs(cur-base);itemWithLeastDistance=this.items[j];
                                    }
                                }
                                if(!itemWithLeastDistance&&!this.options.dropOnEmpty)
                                    continue;this.currentContainer=this.containers[i];itemWithLeastDistance?this.options.sortIndicator.call(this,e,itemWithLeastDistance,null,true):this.options.sortIndicator.call(this,e,null,this.containers[i].element,true);this._propagate("change",e);this.containers[i]._propagate("change",e,this);this.options.placeholder.update(this.currentContainer,this.placeholder);
                            }
                            this.containers[i]._propagate("over",e,this);this.containers[i].containerCache.over=1;
                        }
                    }else{
                        if(this.containers[i].containerCache.over){
                            this.containers[i]._propagate("out",e,this);this.containers[i].containerCache.over=0;
                        }
                    }
                };
            },
            _mouseCapture:function(e,overrideHandle){
                if(this.options.disabled||this.options.type=='static')return false;this._refreshItems();var currentItem=null,self=this,nodes=$(e.target).parents().each(function(){
                    if($.data(this,'sortable-item')==self){
                        currentItem=$(this);return false;
                    }
                });if($.data(e.target,'sortable-item')==self)currentItem=$(e.target);if(!currentItem)return false;if(this.options.handle&&!overrideHandle){
                    var validHandle=false;$(this.options.handle,currentItem).find("*").andSelf().each(function(){
                        if(this==e.target)validHandle=true;
                    });if(!validHandle)return false;
                }
                this.currentItem=currentItem;this._removeCurrentsFromItems();return true;
            },
            createHelper:function(e){
                var o=this.options;var helper=typeof o.helper=='function'?$(o.helper.apply(this.element[0],[e,this.currentItem])):(o.helper=="original"?this.currentItem:this.currentItem.clone());if(!helper.parents('body').length)
                    $(o.appendTo!='parent'?o.appendTo:this.currentItem[0].parentNode)[0].appendChild(helper[0]);return helper;
            },
            _mouseStart:function(e,overrideHandle,noActivation){
                var o=this.options;this.currentContainer=this;this.refreshPositions();this.helper=this.createHelper(e);this.margins={
                    left:(parseInt(this.currentItem.css("marginLeft"),10)||0),
                    top:(parseInt(this.currentItem.css("marginTop"),10)||0)
                };this.offset=this.currentItem.offset();this.offset={
                    top:this.offset.top-this.margins.top,
                    left:this.offset.left-this.margins.left
                };this.offset.click={
                    left:e.pageX-this.offset.left,
                    top:e.pageY-this.offset.top
                };this.offsetParent=this.helper.offsetParent();var po=this.offsetParent.offset();this.offsetParentBorders={
                    top:(parseInt(this.offsetParent.css("borderTopWidth"),10)||0),
                    left:(parseInt(this.offsetParent.css("borderLeftWidth"),10)||0)
                };this.offset.parent={
                    top:po.top+this.offsetParentBorders.top,
                    left:po.left+this.offsetParentBorders.left
                };this.updateOriginalPosition=this.originalPosition=this._generatePosition(e);this.domPosition={
                    prev:this.currentItem.prev()[0],
                    parent:this.currentItem.parent()[0]
                };this.helperProportions={
                    width:this.helper.outerWidth(),
                    height:this.helper.outerHeight()
                };if(o.helper=="original"){
                    this._storedCSS={
                        position:this.currentItem.css("position"),
                        top:this.currentItem.css("top"),
                        left:this.currentItem.css("left"),
                        clear:this.currentItem.css("clear")
                    };
                }else{
                    this.currentItem.hide();
                }
                this.helper.css({
                    position:'absolute',
                    clear:'both'
                }).addClass('ui-sortable-helper');this._createPlaceholder();this._propagate("start",e);if(!this._preserveHelperProportions)
                    this.helperProportions={
                        width:this.helper.outerWidth(),
                        height:this.helper.outerHeight()
                    };if(o.cursorAt){
                    if(o.cursorAt.left!=undefined)this.offset.click.left=o.cursorAt.left;if(o.cursorAt.right!=undefined)this.offset.click.left=this.helperProportions.width-o.cursorAt.right;if(o.cursorAt.top!=undefined)this.offset.click.top=o.cursorAt.top;if(o.cursorAt.bottom!=undefined)this.offset.click.top=this.helperProportions.height-o.cursorAt.bottom;
                }
                if(o.containment){
                    if(o.containment=='parent')o.containment=this.helper[0].parentNode;if(o.containment=='document'||o.containment=='window')this.containment=[0-this.offset.parent.left,0-this.offset.parent.top,$(o.containment=='document'?document:window).width()-this.offset.parent.left-this.helperProportions.width-this.margins.left-(parseInt(this.element.css("marginRight"),10)||0),($(o.containment=='document'?document:window).height()||document.body.parentNode.scrollHeight)-this.offset.parent.top-this.helperProportions.height-this.margins.top-(parseInt(this.element.css("marginBottom"),10)||0)];if(!(/^(document|window|parent)$/).test(o.containment)){
                        var ce=$(o.containment)[0];var co=$(o.containment).offset();var over=($(ce).css("overflow")!='hidden');this.containment=[co.left+(parseInt($(ce).css("borderLeftWidth"),10)||0)-this.offset.parent.left,co.top+(parseInt($(ce).css("borderTopWidth"),10)||0)-this.offset.parent.top,co.left+(over?Math.max(ce.scrollWidth,ce.offsetWidth):ce.offsetWidth)-(parseInt($(ce).css("borderLeftWidth"),10)||0)-this.offset.parent.left-this.helperProportions.width-this.margins.left-(parseInt(this.currentItem.css("marginRight"),10)||0),co.top+(over?Math.max(ce.scrollHeight,ce.offsetHeight):ce.offsetHeight)-(parseInt($(ce).css("borderTopWidth"),10)||0)-this.offset.parent.top-this.helperProportions.height-this.margins.top-(parseInt(this.currentItem.css("marginBottom"),10)||0)];
                    }
                }
                if(!noActivation){
                    for(var i=this.containers.length-1;i>=0;i--){
                        this.containers[i]._propagate("activate",e,this);
                    }
                }
                if($.ui.ddmanager)
                    $.ui.ddmanager.current=this;if($.ui.ddmanager&&!o.dropBehaviour)
                    $.ui.ddmanager.prepareOffsets(this,e);this.dragging=true;this._mouseDrag(e);return true;
            },
            _convertPositionTo:function(d,pos){
                if(!pos)pos=this.position;var mod=d=="absolute"?1:-1;return{
                    top:(pos.top
                        +this.offset.parent.top*mod
                        -(this.offsetParent[0]==document.body?0:this.offsetParent[0].scrollTop)*mod
                        +this.margins.top*mod),
                    left:(pos.left
                        +this.offset.parent.left*mod
                        -(this.offsetParent[0]==document.body?0:this.offsetParent[0].scrollLeft)*mod
                        +this.margins.left*mod)
                };
            },
            _generatePosition:function(e){
                var o=this.options;var position={
                    top:(e.pageY
                        -this.offset.click.top
                        -this.offset.parent.top
                        +(this.offsetParent[0]==document.body?0:this.offsetParent[0].scrollTop)),
                    left:(e.pageX
                        -this.offset.click.left
                        -this.offset.parent.left
                        +(this.offsetParent[0]==document.body?0:this.offsetParent[0].scrollLeft))
                };if(!this.originalPosition)return position;if(this.containment){
                    if(position.left<this.containment[0])position.left=this.containment[0];if(position.top<this.containment[1])position.top=this.containment[1];if(position.left>this.containment[2])position.left=this.containment[2];if(position.top>this.containment[3])position.top=this.containment[3];
                }
                if(o.grid){
                    var top=this.originalPosition.top+Math.round((position.top-this.originalPosition.top)/o.grid[1])*o.grid[1];position.top=this.containment?(!(top<this.containment[1]||top>this.containment[3])?top:(!(top<this.containment[1])?top-o.grid[1]:top+o.grid[1])):top;var left=this.originalPosition.left+Math.round((position.left-this.originalPosition.left)/o.grid[0])*o.grid[0];position.left=this.containment?(!(left<this.containment[0]||left>this.containment[2])?left:(!(left<this.containment[0])?left-o.grid[0]:left+o.grid[0])):left;
                }
                return position;
            },
            _mouseDrag:function(e){
                this.position=this._generatePosition(e);this.positionAbs=this._convertPositionTo("absolute");$.ui.plugin.call(this,"sort",[e,this.ui()]);this.positionAbs=this._convertPositionTo("absolute");this.helper[0].style.left=this.position.left+'px';this.helper[0].style.top=this.position.top+'px';for(var i=this.items.length-1;i>=0;i--){
                    var intersection=this._intersectsWithEdge(this.items[i]);if(!intersection)continue;if(this.items[i].item[0]!=this.currentItem[0]&&this.placeholder[intersection==1?"next":"prev"]()[0]!=this.items[i].item[0]&&!contains(this.placeholder[0],this.items[i].item[0])&&(this.options.type=='semi-dynamic'?!contains(this.element[0],this.items[i].item[0]):true)){
                        this.updateOriginalPosition=this._generatePosition(e);this.direction=intersection==1?"down":"up";this.options.sortIndicator.call(this,e,this.items[i]);this._propagate("change",e);break;
                    }
                }
                this._contactContainers(e);if($.ui.ddmanager)$.ui.ddmanager.drag(this,e);this.element.triggerHandler("sort",[e,this.ui()],this.options["sort"]);return false;
            },
            _rearrange:function(e,i,a,hardRefresh){
                a?a[0].appendChild(this.placeholder[0]):i.item[0].parentNode.insertBefore(this.placeholder[0],(this.direction=='down'?i.item[0]:i.item[0].nextSibling));this.counter=this.counter?++this.counter:1;var self=this,counter=this.counter;window.setTimeout(function(){
                    if(counter==self.counter)self.refreshPositions(!hardRefresh);
                },0);
            },
            _mouseStop:function(e,noPropagation){
                if($.ui.ddmanager&&!this.options.dropBehaviour)
                    $.ui.ddmanager.drop(this,e);if(this.options.revert){
                    var self=this;var cur=self.placeholder.offset();$(this.helper).animate({
                        left:cur.left-this.offset.parent.left-self.margins.left+(this.offsetParent[0]==document.body?0:this.offsetParent[0].scrollLeft),
                        top:cur.top-this.offset.parent.top-self.margins.top+(this.offsetParent[0]==document.body?0:this.offsetParent[0].scrollTop)
                    },parseInt(this.options.revert,10)||500,function(){
                        self._clear(e);
                    });
                }else{
                    this._clear(e,noPropagation);
                }
                return false;
            },
            _clear:function(e,noPropagation){
                if(!this._noFinalSort)this.placeholder.before(this.currentItem);this._noFinalSort=null;if(this.options.helper=="original")
                    this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper");else
                    this.currentItem.show();if(this.domPosition.prev!=this.currentItem.prev().not(".ui-sortable-helper")[0]||this.domPosition.parent!=this.currentItem.parent()[0])this._propagate("update",e,null,noPropagation);if(!contains(this.element[0],this.currentItem[0])){
                    this._propagate("remove",e,null,noPropagation);for(var i=this.containers.length-1;i>=0;i--){
                        if(contains(this.containers[i].element[0],this.currentItem[0])){
                            this.containers[i]._propagate("update",e,this,noPropagation);this.containers[i]._propagate("receive",e,this,noPropagation);
                        }
                    };
                };for(var i=this.containers.length-1;i>=0;i--){
                    this.containers[i]._propagate("deactivate",e,this,noPropagation);if(this.containers[i].containerCache.over){
                        this.containers[i]._propagate("out",e,this);this.containers[i].containerCache.over=0;
                    }
                }
                this.dragging=false;if(this.cancelHelperRemoval){
                    this._propagate("beforeStop",e,null,noPropagation);this._propagate("stop",e,null,noPropagation);return false;
                }
                this._propagate("beforeStop",e,null,noPropagation);this.placeholder.remove();if(this.options.helper!="original")this.helper.remove();this.helper=null;this._propagate("stop",e,null,noPropagation);return true;
            }
        }));$.extend($.ui.sortable,{
        getter:"serialize toArray",
        defaults:{
            helper:"original",
            tolerance:"guess",
            distance:1,
            delay:0,
            scroll:true,
            scrollSensitivity:20,
            scrollSpeed:20,
            cancel:":input",
            items:'> *',
            zIndex:1000,
            dropOnEmpty:true,
            appendTo:"parent",
            sortIndicator:$.ui.sortable.prototype._rearrange,
            scope:"default",
            forcePlaceholderSize:false
        }
    });$.ui.plugin.add("sortable","cursor",{
        start:function(e,ui){
            var t=$('body');if(t.css("cursor"))ui.options._cursor=t.css("cursor");t.css("cursor",ui.options.cursor);
        },
        beforeStop:function(e,ui){
            if(ui.options._cursor)$('body').css("cursor",ui.options._cursor);
        }
    });$.ui.plugin.add("sortable","zIndex",{
        start:function(e,ui){

            var t=ui.helper;if(t.css("zIndex"))ui.options._zIndex=t.css("zIndex");t.css('zIndex',ui.options.zIndex);
        },
        beforeStop:function(e,ui){
            if(ui.options._zIndex)$(ui.helper).css('zIndex',ui.options._zIndex);
        }
    });$.ui.plugin.add("sortable","opacity",{
        start:function(e,ui){
            var t=ui.helper;if(t.css("opacity"))ui.options._opacity=t.css("opacity");t.css('opacity',ui.options.opacity);
        },
        beforeStop:function(e,ui){
            if(ui.options._opacity)$(ui.helper).css('opacity',ui.options._opacity);
        }
    });$.ui.plugin.add("sortable","scroll",{
        start:function(e,ui){
            var o=ui.options;var i=$(this).data("sortable");i.overflowY=function(el){
                do{
                    if(/auto|scroll/.test(el.css('overflow'))||(/auto|scroll/).test(el.css('overflow-y')))return el;el=el.parent();
                }while(el[0].parentNode);return $(document);
            }(i.currentItem);i.overflowX=function(el){
                do{
                    if(/auto|scroll/.test(el.css('overflow'))||(/auto|scroll/).test(el.css('overflow-x')))return el;el=el.parent();
                }while(el[0].parentNode);return $(document);
            }(i.currentItem);if(i.overflowY[0]!=document&&i.overflowY[0].tagName!='HTML')i.overflowYOffset=i.overflowY.offset();if(i.overflowX[0]!=document&&i.overflowX[0].tagName!='HTML')i.overflowXOffset=i.overflowX.offset();
        },
        sort:function(e,ui){
            var o=ui.options;var i=$(this).data("sortable");if(i.overflowY[0]!=document&&i.overflowY[0].tagName!='HTML'){
                if((i.overflowYOffset.top+i.overflowY[0].offsetHeight)-e.pageY<o.scrollSensitivity)
                    i.overflowY[0].scrollTop=i.overflowY[0].scrollTop+o.scrollSpeed;if(e.pageY-i.overflowYOffset.top<o.scrollSensitivity)
                    i.overflowY[0].scrollTop=i.overflowY[0].scrollTop-o.scrollSpeed;
            }else{
                if(e.pageY-$(document).scrollTop()<o.scrollSensitivity)
                    $(document).scrollTop($(document).scrollTop()-o.scrollSpeed);if($(window).height()-(e.pageY-$(document).scrollTop())<o.scrollSensitivity)
                    $(document).scrollTop($(document).scrollTop()+o.scrollSpeed);
            }
            if(i.overflowX[0]!=document&&i.overflowX[0].tagName!='HTML'){
                if((i.overflowXOffset.left+i.overflowX[0].offsetWidth)-e.pageX<o.scrollSensitivity)
                    i.overflowX[0].scrollLeft=i.overflowX[0].scrollLeft+o.scrollSpeed;if(e.pageX-i.overflowXOffset.left<o.scrollSensitivity)
                    i.overflowX[0].scrollLeft=i.overflowX[0].scrollLeft-o.scrollSpeed;
            }else{
                if(e.pageX-$(document).scrollLeft()<o.scrollSensitivity)
                    $(document).scrollLeft($(document).scrollLeft()-o.scrollSpeed);if($(window).width()-(e.pageX-$(document).scrollLeft())<o.scrollSensitivity)
                    $(document).scrollLeft($(document).scrollLeft()+o.scrollSpeed);
            }
        }
    });$.ui.plugin.add("sortable","axis",{
        sort:function(e,ui){
            var i=$(this).data("sortable");if(ui.options.axis=="y")i.position.left=i.originalPosition.left;if(ui.options.axis=="x")i.position.top=i.originalPosition.top;
        }
    });
    })(jQuery);(function($){
    $.widget("ui.accordion",{
        _init:function(){
            var options=this.options;if(options.navigation){
                var current=this.element.find("a").filter(options.navigationFilter);if(current.length){
                    if(current.filter(options.header).length){
                        options.active=current;
                    }else{
                        options.active=current.parent().parent().prev();current.addClass("current");
                    }
                }
            }
            options.headers=this.element.find(options.header);options.active=findActive(options.headers,options.active);if($.browser.msie){
                this.element.find('a').css('zoom','1');
            }
            if(!this.element.hasClass("ui-accordion")){
                this.element.addClass("ui-accordion");$('<span class="ui-accordion-left"/>').insertBefore(options.headers);$('<span class="ui-accordion-right"/>').appendTo(options.headers);options.headers.addClass("ui-accordion-header").attr("tabindex","0");
            }
            var maxHeight;if(options.fillSpace){
                maxHeight=this.element.parent().height();options.headers.each(function(){
                    maxHeight-=$(this).outerHeight();
                });var maxPadding=0;options.headers.next().each(function(){
                    maxPadding=Math.max(maxPadding,$(this).innerHeight()-$(this).height());
                }).height(maxHeight-maxPadding);
            }else if(options.autoHeight){
                maxHeight=0;options.headers.next().each(function(){
                    maxHeight=Math.max(maxHeight,$(this).outerHeight());
                }).height(maxHeight);
            }
            options.headers.not(options.active||"").next().hide();options.active.parent().andSelf().addClass(options.selectedClass);if(options.event){
                this.element.bind((options.event)+".accordion",clickHandler);
            }
        },
        activate:function(index){
            clickHandler.call(this.element[0],{
                target:findActive(this.options.headers,index)[0]
            });
        },
        destroy:function(){
            this.options.headers.next().css("display","");if(this.options.fillSpace||this.options.autoHeight){
                this.options.headers.next().css("height","");
            }
            $.removeData(this.element[0],"accordion");this.element.removeClass("ui-accordion").unbind(".accordion");
        }
    });function scopeCallback(callback,scope){
        return function(){
            return callback.apply(scope,arguments);
        };
    };function completed(cancel){
        if(!$.data(this,"accordion")){
            return;
        }
        var instance=$.data(this,"accordion");var options=instance.options;options.running=cancel?0:--options.running;if(options.running){
            return;
        }
        if(options.clearStyle){
            options.toShow.add(options.toHide).css({
                height:"",
                overflow:""
            });
        }
        instance._trigger('change',null,options.data);
    }
    function toggle(toShow,toHide,data,clickedActive,down){
        var options=$.data(this,"accordion").options;options.toShow=toShow;options.toHide=toHide;options.data=data;var complete=scopeCallback(completed,this);$.data(this,"accordion")._trigger("changestart",null,options.data);options.running=toHide.size()===0?toShow.size():toHide.size();if(options.animated){
            if(!options.alwaysOpen&&clickedActive){
                $.ui.accordion.animations[options.animated]({
                    toShow:jQuery([]),
                    toHide:toHide,
                    complete:complete,
                    down:down,
                    autoHeight:options.autoHeight
                });
            }else{
                $.ui.accordion.animations[options.animated]({
                    toShow:toShow,
                    toHide:toHide,
                    complete:complete,
                    down:down,
                    autoHeight:options.autoHeight
                });
            }
        }else{
            if(!options.alwaysOpen&&clickedActive){
                toShow.toggle();
            }else{
                toHide.hide();toShow.show();
            }
            complete(true);
        }
    }
    function clickHandler(event){
        var options=$.data(this,"accordion").options;if(options.disabled){
            return false;
        }
        if(!event.target&&!options.alwaysOpen){
            options.active.parent().andSelf().toggleClass(options.selectedClass);var toHide=options.active.next(),data={
                options:options,
                newHeader:jQuery([]),
                oldHeader:options.active,
                newContent:jQuery([]),
                oldContent:toHide
            },toShow=(options.active=$([]));toggle.call(this,toShow,toHide,data);return false;
        }
        var clicked=$(event.target);clicked=$(clicked.parents(options.header)[0]||clicked);var clickedActive=clicked[0]==options.active[0];if(options.running||(options.alwaysOpen&&clickedActive)){
            return false;
        }
        if(!clicked.is(options.header)){
            return;
        }
        options.active.parent().andSelf().toggleClass(options.selectedClass);if(!clickedActive){
            clicked.parent().andSelf().addClass(options.selectedClass);
        }
        var toShow=clicked.next(),toHide=options.active.next(),data={
            options:options,
            newHeader:clickedActive&&!options.alwaysOpen?$([]):clicked,
            oldHeader:options.active,
            newContent:clickedActive&&!options.alwaysOpen?$([]):toShow,
            oldContent:toHide
        },down=options.headers.index(options.active[0])>options.headers.index(clicked[0]);options.active=clickedActive?$([]):clicked;toggle.call(this,toShow,toHide,data,clickedActive,down);return false;
    };function findActive(headers,selector){
        return selector?typeof selector=="number"?headers.filter(":eq("+selector+")"):headers.not(headers.not(selector)):selector===false?$([]):headers.filter(":eq(0)");
    }
    $.extend($.ui.accordion,{
        defaults:{
            selectedClass:"selected",
            alwaysOpen:true,
            animated:'slide',
            event:"click",
            header:"a",
            autoHeight:true,
            running:0,
            navigationFilter:function(){
                return this.href.toLowerCase()==location.href.toLowerCase();
            }
        },
        animations:{
            slide:function(options,additions){
                options=$.extend({
                    easing:"swing",
                    duration:300
                },options,additions);if(!options.toHide.size()){
                    options.toShow.animate({
                        height:"show"
                    },options);return;
                }
                var hideHeight=options.toHide.height(),showHeight=options.toShow.height(),difference=showHeight/hideHeight;options.toShow.css({
                    height:0,
                    overflow:'hidden'
                }).show();options.toHide.filter(":hidden").each(options.complete).end().filter(":visible").animate({
                    height:"hide"
                },{
                    step:function(now){
                        var current=(hideHeight-now)*difference;if($.browser.msie||$.browser.opera){
                            current=Math.ceil(current);
                        }
                        options.toShow.height(current);
                    },
                    duration:options.duration,
                    easing:options.easing,
                    complete:function(){
                        if(!options.autoHeight){
                            options.toShow.css("height","auto");
                        }
                        options.complete();
                    }
                });
            },
            bounceslide:function(options){
                this.slide(options,{
                    easing:options.down?"bounceout":"swing",
                    duration:options.down?1000:200
                });
            },
            easeslide:function(options){
                this.slide(options,{
                    easing:"easeinout",
                    duration:700
                });
            }
        }
    });
})(jQuery);(function($){
    $.widget("ui.autocomplete",{
        _init:function(){
            $.extend(this.options,{
                delay:this.options.url?$.Autocompleter.defaults.delay:10,
                max:!this.options.scroll?10:150,
                highlight:this.options.highlight||function(value){
                    return value;
                },
                formatMatch:this.options.formatMatch||this.options.formatItem
            });new $.Autocompleter(this.element[0],this.options);
        },
        result:function(handler){
            return this.element.bind("result",handler);
        },
        search:function(handler){
            return this.element.trigger("search",[handler]);
        },
        flushCache:function(){
            return this.element.trigger("flushCache");
        },
        setData:function(key,value){
            return this.element.trigger("setOptions",[{
                key:value
            }]);
        },
        destroy:function(){
            return this.element.trigger("unautocomplete");
        }
    });$.Autocompleter=function(input,options){
        var KEY={
            UP:38,
            DOWN:40,
            DEL:46,
            TAB:9,
            RETURN:13,
            ESC:27,
            COMMA:188,
            PAGEUP:33,
            PAGEDOWN:34,
            BACKSPACE:8
        };var $input=$(input).attr("autocomplete","off").addClass(options.inputClass);if(options.result)$input.bind('result.autocomplete',options.result);var timeout;var previousValue="";var cache=$.Autocompleter.Cache(options);var hasFocus=0;var lastKeyPressCode;var config={
            mouseDownOnSelect:false
        };var select=$.Autocompleter.Select(options,input,selectCurrent,config);var blockSubmit;$.browser.opera&&$(input.form).bind("submit.autocomplete",function(){
            if(blockSubmit){
                blockSubmit=false;return false;
            }
        });$input.bind(($.browser.opera?"keypress":"keydown")+".autocomplete",function(event){
            lastKeyPressCode=event.keyCode;switch(event.keyCode){
                case KEY.UP:event.preventDefault();if(select.visible()){
                    select.prev();
                }else{
                    onChange(0,true);
                }
                break;case KEY.DOWN:event.preventDefault();if(select.visible()){
                    select.next();
                }else{
                    onChange(0,true);
                }
                break;case KEY.PAGEUP:event.preventDefault();if(select.visible()){
                    select.pageUp();
                }else{
                    onChange(0,true);
                }
                break;case KEY.PAGEDOWN:event.preventDefault();if(select.visible()){
                    select.pageDown();
                }else{
                    onChange(0,true);
                }
                break;case options.multiple&&$.trim(options.multipleSeparator)==","&&KEY.COMMA:case KEY.TAB:case KEY.RETURN:if(selectCurrent()){
                    event.preventDefault();blockSubmit=true;return false;
                }
                break;case KEY.ESC:select.hide();break;default:clearTimeout(timeout);timeout=setTimeout(onChange,options.delay);break;
            }
        }).focus(function(){
            hasFocus++;
        }).blur(function(){
            hasFocus=0;if(!config.mouseDownOnSelect){
                hideResults();
            }
        }).click(function(){
            if(hasFocus++>1&&!select.visible()){
                onChange(0,true);
            }
        }).bind("search",function(){
            var fn=(arguments.length>1)?arguments[1]:null;function findValueCallback(q,data){
                var result;if(data&&data.length){
                    for(var i=0;i<data.length;i++){
                        if(data[i].result.toLowerCase()==q.toLowerCase()){
                            result=data[i];break;
                        }
                    }
                }
                if(typeof fn=="function")fn(result);else $input.trigger("result",result&&[result.data,result.value]);
            }
            $.each(trimWords($input.val()),function(i,value){
                request(value,findValueCallback,findValueCallback);
            });
        }).bind("flushCache",function(){
            cache.flush();
        }).bind("setOptions",function(){
            $.extend(options,arguments[1]);if("data"in arguments[1])
                cache.populate();
        }).bind("unautocomplete",function(){
            select.unbind();$input.unbind();$(input.form).unbind(".autocomplete");
        });function selectCurrent(){
            var selected=select.selected();if(!selected)
                return false;var v=selected.result;previousValue=v;if(options.multiple){
                var words=trimWords($input.val());if(words.length>1){
                    v=words.slice(0,words.length-1).join(options.multipleSeparator)+options.multipleSeparator+v;
                }
                v+=options.multipleSeparator;
            }
            $input.val(v);hideResultsNow();$input.trigger("result",[selected.data,selected.value]);return true;
        }
        function onChange(crap,skipPrevCheck){
            if(lastKeyPressCode==KEY.DEL){
                select.hide();return;
            }
            var currentValue=$input.val();if(!skipPrevCheck&&currentValue==previousValue)
                return;previousValue=currentValue;currentValue=lastWord(currentValue);if(currentValue.length>=options.minChars){
                $input.addClass(options.loadingClass);if(!options.matchCase)
                    currentValue=currentValue.toLowerCase();request(currentValue,receiveData,hideResultsNow);
            }else{
                stopLoading();select.hide();
            }
        };function trimWords(value){
            if(!value){
                return[""];
            }
            var words=value.split(options.multipleSeparator);var result=[];$.each(words,function(i,value){
                if($.trim(value))
                    result[i]=$.trim(value);
            });return result;
        }
        function lastWord(value){
            if(!options.multiple)
                return value;var words=trimWords(value);return words[words.length-1];
        }
        function autoFill(q,sValue){
            if(options.autoFill&&(lastWord($input.val()).toLowerCase()==q.toLowerCase())&&lastKeyPressCode!=KEY.BACKSPACE){
                $input.val($input.val()+sValue.substring(lastWord(previousValue).length));$.Autocompleter.Selection(input,previousValue.length,previousValue.length+sValue.length);
            }
        };function hideResults(){
            clearTimeout(timeout);timeout=setTimeout(hideResultsNow,200);
        };function hideResultsNow(){
            var wasVisible=select.visible();select.hide();clearTimeout(timeout);stopLoading();if(options.mustMatch){
                $input.autocomplete("search",function(result){
                    if(!result){
                        if(options.multiple){
                            var words=trimWords($input.val()).slice(0,-1);$input.val(words.join(options.multipleSeparator)+(words.length?options.multipleSeparator:""));
                        }
                        else
                            $input.val("");
                    }
                });
            }
            if(wasVisible)
                $.Autocompleter.Selection(input,input.value.length,input.value.length);
        };function receiveData(q,data){
            if(data&&data.length&&hasFocus){
                stopLoading();select.display(data,q);autoFill(q,data[0].value);select.show();
            }else{
                hideResultsNow();
            }
        };function request(term,success,failure){
            if(!options.matchCase)
                term=term.toLowerCase();var data=cache.load(term);if(data&&data.length){
                success(term,data);
            }else if((typeof options.url=="string")&&(options.url.length>0)){
                var extraParams={
                    timestamp:+new Date()
                };$.each(options.extraParams,function(key,param){
                    extraParams[key]=typeof param=="function"?param():param;
                });$.ajax({
                    mode:"abort",
                    port:"autocomplete"+input.name,
                    dataType:options.dataType,
                    url:options.url,
                    data:$.extend({
                        q:lastWord(term),
                        limit:options.max
                    },extraParams),
                    success:function(data){
                        var parsed=options.parse&&options.parse(data)||parse(data);cache.add(term,parsed);success(term,parsed);
                    }
                });
            }
            else if(options.source&&typeof options.source=='function'){
                var resultData=options.source(term);var parsed=(options.parse)?options.parse(resultData):resultData;cache.add(term,parsed);success(term,parsed);
            }else{
                select.emptyList();failure(term);
            }
        };function parse(data){
            var parsed=[];var rows=data.split("\n");for(var i=0;i<rows.length;i++){
                var row=$.trim(rows[i]);if(row){
                    row=row.split("|");parsed[parsed.length]={
                        data:row,
                        value:row[0],
                        result:options.formatResult&&options.formatResult(row,row[0])||row[0]
                    };
                }
            }
            return parsed;
        };function stopLoading(){
            $input.removeClass(options.loadingClass);
        };
    };$.Autocompleter.defaults={
        inputClass:"ui-autocomplete-input",
        resultsClass:"ui-autocomplete-results",
        loadingClass:"ui-autocomplete-loading",
        minChars:1,
        delay:400,
        matchCase:false,
        matchSubset:true,
        matchContains:false,
        cacheLength:10,
        max:100,
        mustMatch:false,
        extraParams:{},
        selectFirst:true,
        formatItem:function(row){
            return row[0];
        },
        formatMatch:null,
        autoFill:false,
        width:0,
        multiple:false,
        multipleSeparator:", ",
        highlight:function(value,term){
            return value.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)("+term.replace(/([\^\$\(\)\[\]\{\}\*\.\+\?\|\\])/gi,"\\$1")+")(?![^<>]*>)(?![^&;]+;)","gi"),"<strong>$1</strong>");
        },
        scroll:true,
        scrollHeight:180
    };$.extend($.ui.autocomplete,{
        defaults:$.Autocompleter.defaults
    });$.Autocompleter.Cache=function(options){
        var data={};var length=0;function matchSubset(s,sub){
            if(!options.matchCase)
                s=s.toLowerCase();var i=s.indexOf(sub);if(i==-1)return false;return i==0||options.matchContains;
        };function add(q,value){
            if(length>options.cacheLength){
                flush();
            }
            if(!data[q]){
                length++;
            }
            data[q]=value;
        }
        function populate(){
            if(!options.data)return false;var stMatchSets={},nullData=0;if(!options.url)options.cacheLength=1;stMatchSets[""]=[];for(var i=0,ol=options.data.length;i<ol;i++){
                var rawValue=options.data[i];rawValue=(typeof rawValue=="string")?[rawValue]:rawValue;var value=options.formatMatch(rawValue,i+1,options.data.length);if(value===false)
                    continue;var firstChar=value.charAt(0).toLowerCase();if(!stMatchSets[firstChar])
                    stMatchSets[firstChar]=[];var row={
                    value:value,
                    data:rawValue,
                    result:options.formatResult&&options.formatResult(rawValue)||value
                };stMatchSets[firstChar].push(row);if(nullData++<options.max){
                    stMatchSets[""].push(row);
                }
            };$.each(stMatchSets,function(i,value){
                options.cacheLength++;add(i,value);
            });
        }
        setTimeout(populate,25);function flush(){
            data={};length=0;
        }
        return{
            flush:flush,
            add:add,
            populate:populate,
            load:function(q){
                if(!options.cacheLength||!length)
                    return null;if(!options.url&&options.matchContains){
                    var csub=[];for(var k in data){
                        if(k.length>0){
                            var c=data[k];$.each(c,function(i,x){
                                if(matchSubset(x.value,q)){
                                    csub.push(x);
                                }
                            });
                        }
                    }
                    return csub;
                }else
                if(data[q]){
                    return data[q];
                }else
                if(options.matchSubset){
                    for(var i=q.length-1;i>=options.minChars;i--){
                        var c=data[q.substr(0,i)];if(c){
                            var csub=[];$.each(c,function(i,x){
                                if(matchSubset(x.value,q)){
                                    csub[csub.length]=x;
                                }
                            });return csub;
                        }
                    }
                }
                return null;
            }
        };
    };$.Autocompleter.Select=function(options,input,select,config){
        var CLASSES={
            ACTIVE:"ui-autocomplete-over"
        };var listItems,active=-1,data,term="",needsInit=true,element,list;function init(){
            if(!needsInit)
                return;element=$("<div/>").hide().addClass(options.resultsClass).css("position","absolute").appendTo(document.body);list=$("<ul/>").appendTo(element).mouseover(function(event){
                if(target(event).nodeName&&target(event).nodeName.toUpperCase()=='LI'){
                    active=$("li",list).removeClass(CLASSES.ACTIVE).index(target(event));$(target(event)).addClass(CLASSES.ACTIVE);
                }
            }).click(function(event){
                $(target(event)).addClass(CLASSES.ACTIVE);select();input.focus();return false;
            }).mousedown(function(){
                config.mouseDownOnSelect=true;
            }).mouseup(function(){
                config.mouseDownOnSelect=false;
            });if(options.width>0)
                element.css("width",options.width);needsInit=false;
        }
        function target(event){
            var element=event.target;while(element&&element.tagName!="LI")
                element=element.parentNode;if(!element)
                return[];return element;
        }
        function moveSelect(step){
            listItems.slice(active,active+1).removeClass(CLASSES.ACTIVE);movePosition(step);var activeItem=listItems.slice(active,active+1).addClass(CLASSES.ACTIVE);if(options.scroll){
                var offset=0;listItems.slice(0,active).each(function(){
                    offset+=this.offsetHeight;
                });if((offset+activeItem[0].offsetHeight-list.scrollTop())>list[0].clientHeight){
                    list.scrollTop(offset+activeItem[0].offsetHeight-list.innerHeight());
                }else if(offset<list.scrollTop()){
                    list.scrollTop(offset);
                }
            }
        };function movePosition(step){
            active+=step;if(active<0){
                active=listItems.size()-1;
            }else if(active>=listItems.size()){
                active=0;
            }
        }
        function limitNumberOfItems(available){
            return options.max&&options.max<available?options.max:available;
        }
        function fillList(){
            list.empty();var max=limitNumberOfItems(data.length);for(var i=0;i<max;i++){
                if(!data[i])
                    continue;var formatted=options.formatItem(data[i].data,i+1,max,data[i].value,term);if(formatted===false)
                    continue;var li=$("<li/>").html(options.highlight(formatted,term)).addClass(i%2==0?"ui-autocomplete-even":"ui-autocomplete-odd").appendTo(list)[0];$.data(li,"ui-autocomplete-data",data[i]);
            }
            listItems=list.find("li");if(options.selectFirst){
                listItems.slice(0,1).addClass(CLASSES.ACTIVE);active=0;
            }
            if($.fn.bgiframe)
                list.bgiframe();
        }
        return{
            display:function(d,q){
                init();data=d;term=q;fillList();
            },
            next:function(){
                moveSelect(1);
            },
            prev:function(){
                moveSelect(-1);
            },
            pageUp:function(){
                if(active!=0&&active-8<0){
                    moveSelect(-active);
                }else{
                    moveSelect(-8);
                }
            },
            pageDown:function(){
                if(active!=listItems.size()-1&&active+8>listItems.size()){
                    moveSelect(listItems.size()-1-active);
                }else{
                    moveSelect(8);
                }
            },
            hide:function(){
                element&&element.hide();listItems&&listItems.removeClass(CLASSES.ACTIVE)
                active=-1;$(input).triggerHandler("autocompletehide",[{},{
                    options:options
                }],options["hide"]);
            },
            visible:function(){
                return element&&element.is(":visible");
            },
            current:function(){
                return this.visible()&&(listItems.filter("."+CLASSES.ACTIVE)[0]||options.selectFirst&&listItems[0]);
            },
            show:function(){
                var offset=$(input).offset();element.css({
                    width:typeof options.width=="string"||options.width>0?options.width:$(input).width(),
                    top:offset.top+input.offsetHeight,
                    left:offset.left
                }).show();if(options.scroll){
                    list.scrollTop(0);list.css({
                        maxHeight:options.scrollHeight,
                        overflow:'auto'
                    });if($.browser.msie&&typeof document.body.style.maxHeight==="undefined"){
                        var listHeight=0;listItems.each(function(){
                            listHeight+=this.offsetHeight;
                        });var scrollbarsVisible=listHeight>options.scrollHeight;list.css('height',scrollbarsVisible?options.scrollHeight:listHeight);if(!scrollbarsVisible){
                            listItems.width(list.width()-parseInt(listItems.css("padding-left"))-parseInt(listItems.css("padding-right")));
                        }
                    }
                }
                $(input).triggerHandler("autocompleteshow",[{},{
                    options:options
                }],options["show"]);
            },
            selected:function(){
                var selected=listItems&&listItems.filter("."+CLASSES.ACTIVE).removeClass(CLASSES.ACTIVE);return selected&&selected.length&&$.data(selected[0],"ui-autocomplete-data");
            },
            emptyList:function(){
                list&&list.empty();
            },
            unbind:function(){
                element&&element.remove();
            }
        };
    };$.Autocompleter.Selection=function(field,start,end){
        if(field.createTextRange){
            var selRange=field.createTextRange();selRange.collapse(true);selRange.moveStart("character",start);selRange.moveEnd("character",end);selRange.select();
        }else if(field.setSelectionRange){
            field.setSelectionRange(start,end);
        }else{
            if(field.selectionStart){
                field.selectionStart=start;field.selectionEnd=end;
            }
        }
        field.focus();
    };
})(jQuery);(function($){
    $.widget("ui.colorpicker",{
        _init:function(){
            this.charMin=65;var o=this.options,self=this,tpl='<div class="ui-colorpicker clearfix"><div class="ui-colorpicker-color"><div><div></div></div></div><div class="ui-colorpicker-hue"><div></div></div><div class="ui-colorpicker-new-color"></div><div class="ui-colorpicker-current-color"></div><div class="ui-colorpicker-hex"><label for="ui-colorpicker-hex" title="hex"></label><input type="text" maxlength="6" size="6" /></div><div class="ui-colorpicker-rgb-r ui-colorpicker-field"><label for="ui-colorpicker-rgb-r"></label><input type="text" maxlength="3" size="2" /><span></span></div><div class="ui-colorpicker-rgb-g ui-colorpicker-field"><label for="ui-colorpicker-rgb-g"></label><input type="text" maxlength="3" size="2" /><span></span></div><div class="ui-colorpicker-rgb-b ui-colorpicker-field"><label for="ui-colorpicker-rgb-b"</label><input type="text" maxlength="3" size="2" /><span></span></div><div class="ui-colorpicker-hsb-h ui-colorpicker-field"><label for="ui-colorpicker-hsb-h"></label><input type="text" maxlength="3" size="2" /><span></span></div><div class="ui-colorpicker-hsb-s ui-colorpicker-field"><label for="ui-colorpicker-hsb-s"></label><input type="text" maxlength="3" size="2" /><span></span></div><div class="ui-colorpicker-hsb-b ui-colorpicker-field"><label for="ui-colorpicker-hsb-b"></label><input type="text" maxlength="3" size="2" /><span></span></div><button class="ui-colorpicker-submit ui-default-state" name="submit" type="button">Done</button></div>';if(typeof o.color=='string'){
                this.color=this._HexToHSB(o.color);
            }else if(o.color.r!=undefined&&o.color.g!=undefined&&o.color.b!=undefined){
                this.color=this._RGBToHSB(o.color);
            }else if(o.color.h!=undefined&&o.color.s!=undefined&&o.color.b!=undefined){
                this.color=this._fixHSB(o.color);
            }else{
                return this;
            }
            this.origColor=this.color;this.picker=$(tpl);if(o.flat){
                this.picker.appendTo(this.element).show();
            }else{
                this.picker.appendTo(document.body);
            }
            this.fields=this.picker.find('input').bind('keydown',function(e){
                return self._keyDown.call(self,e);
            }).bind('change',function(e){
                return self._change.call(self,e);
            }).bind('blur',function(e){
                return self._blur.call(self,e);
            }).bind('focus',function(e){
                return self._focus.call(self,e);
            });this.picker.find('span').bind('mousedown',function(e){
                return self._downIncrement.call(self,e);
            });this.selector=this.picker.find('div.ui-colorpicker-color').bind('mousedown',function(e){
                return self._downSelector.call(self,e);
            });this.selectorIndic=this.selector.find('div div');this.hue=this.picker.find('div.ui-colorpicker-hue div');this.picker.find('div.ui-colorpicker-hue').bind('mousedown',function(e){
                return self._downHue.call(self,e);
            });this.newColor=this.picker.find('div.ui-colorpicker-new-color');this.currentColor=this.picker.find('div.ui-colorpicker-current-color');this.picker.find('.ui-colorpicker-submit').bind('mouseenter',function(e){
                return self._enterSubmit.call(self,e);
            }).bind('mouseleave',function(e){
                return self._leaveSubmit.call(self,e);
            }).bind('click',function(e){
                return self._clickSubmit.call(self,e);
            });this._fillRGBFields(this.color);this._fillHSBFields(this.color);this._fillHexFields(this.color);this._setHue(this.color);this._setSelector(this.color);this._setCurrentColor(this.color);this._setNewColor(this.color);if(o.flat){
                this.picker.css({
                    position:'relative',
                    display:'block'
                });
            }else{
                $(this.element).bind(o.eventName+".colorpicker",function(e){
                    return self._show.call(self,e);
                });
            }
        },
        destroy:function(){
            this.picker.remove();this.element.removeData("colorpicker").unbind(".colorpicker");
        },
        _fillRGBFields:function(hsb){
            var rgb=this._HSBToRGB(hsb);this.fields.eq(1).val(rgb.r).end().eq(2).val(rgb.g).end().eq(3).val(rgb.b).end();
        },
        _fillHSBFields:function(hsb){
            this.fields.eq(4).val(hsb.h).end().eq(5).val(hsb.s).end().eq(6).val(hsb.b).end();
        },
        _fillHexFields:function(hsb){
            this.fields.eq(0).val(this._HSBToHex(hsb)).end();
        },
        _setSelector:function(hsb){
            this.selector.css('backgroundColor','#'+this._HSBToHex({
                h:hsb.h,
                s:100,
                b:100
            }));this.selectorIndic.css({
                left:parseInt(150*hsb.s/100,10),
                top:parseInt(150*(100-hsb.b)/100,10)
            });
        },
        _setHue:function(hsb){
            this.hue.css('top',parseInt(150-150*hsb.h/360,10));
        },
        _setCurrentColor:function(hsb){
            this.currentColor.css('backgroundColor','#'+this._HSBToHex(hsb));
        },
        _setNewColor:function(hsb){
            this.newColor.css('backgroundColor','#'+this._HSBToHex(hsb));
        },
        _keyDown:function(e){
            var pressedKey=e.charCode||e.keyCode||-1;if((pressedKey>=this.charMin&&pressedKey<=90)||pressedKey==32){
                return false;
            }
        },
        _change:function(e,target){
            var col;target=target||e.target;if(target.parentNode.className.indexOf('-hex')>0){
                this.color=col=this._HexToHSB(this.value);this._fillRGBFields(col.color);this._fillHSBFields(col);
            }else if(target.parentNode.className.indexOf('-hsb')>0){
                this.color=col=this._fixHSB({
                    h:parseInt(this.fields.eq(4).val(),10),
                    s:parseInt(this.fields.eq(5).val(),10),
                    b:parseInt(this.fields.eq(6).val(),10)
                });this._fillRGBFields(col);this._fillHexFields(col);
            }else{
                this.color=col=this._RGBToHSB(this._fixRGB({
                    r:parseInt(this.fields.eq(1).val(),10),
                    g:parseInt(this.fields.eq(2).val(),10),
                    b:parseInt(this.fields.eq(3).val(),10)
                }));this._fillHexFields(col);this._fillHSBFields(col);
            }
            this._setSelector(col);this._setHue(col);this._setNewColor(col);this._trigger('change',e,{
                options:this.options,
                hsb:col,
                hex:this._HSBToHex(col),
                rgb:this._HSBToRGB(col)
            });
        },
        _blur:function(e){
            var col=this.color;this._fillRGBFields(col);this._fillHSBFields(col);this._fillHexFields(col);this._setHue(col);this._setSelector(col);this._setNewColor(col);this.fields.parent().removeClass('ui-colorpicker-focus');
        },
        _focus:function(e){
            this.charMin=e.target.parentNode.className.indexOf('-hex')>0?70:65;this.fields.parent().removeClass('ui-colorpicker-focus');$(e.target.parentNode).addClass('ui-colorpicker-focus');
        },
        _downIncrement:function(e){
            var field=$(e.target).parent().find('input').focus(),self=this;this.currentIncrement={
                el:$(e.target).parent().addClass('ui-colorpicker-slider'),
                max:e.target.parentNode.className.indexOf('-hsb-h')>0?360:(e.target.parentNode.className.indexOf('-hsb')>0?100:255),
                y:e.pageY,
                field:field,
                val:parseInt(field.val(),10)
            };$(document).bind('mouseup.cpSlider',function(e){
                return self._upIncrement.call(self,e);
            });$(document).bind('mousemove.cpSlider',function(e){
                return self._moveIncrement.call(self,e);
            });return false;
        },
        _moveIncrement:function(e){
            this.currentIncrement.field.val(Math.max(0,Math.min(this.currentIncrement.max,parseInt(this.currentIncrement.val+e.pageY-this.currentIncrement.y,10))));this._change.apply(this,[e,this.currentIncrement.field.get(0)]);return false;
        },
        _upIncrement:function(e){
            this.currentIncrement.el.removeClass('ui-colorpicker-slider').find('input').focus();this._change.apply(this,[e,this.currentIncrement.field.get(0)]);$(document).unbind('mouseup.cpSlider');$(document).unbind('mousemove.cpSlider');return false;
        },
        _downHue:function(e){
            this.currentHue={
                y:this.picker.find('div.ui-colorpicker-hue').offset().top
            };this._change.apply(this,[e,this.fields.eq(4).val(parseInt(360*(150-Math.max(0,Math.min(150,(e.pageY-this.currentHue.y))))/150,10)).get(0)]);var self=this;$(document).bind('mouseup.cpSlider',function(e){
                return self._upHue.call(self,e);
            });$(document).bind('mousemove.cpSlider',function(e){
                return self._moveHue.call(self,e);
            });return false;
        },
        _moveHue:function(e){
            this._change.apply(this,[e,this.fields.eq(4).val(parseInt(360*(150-Math.max(0,Math.min(150,(e.pageY-this.currentHue.y))))/150,10)).get(0)]);return false;
        },
        _upHue:function(e){
            $(document).unbind('mouseup.cpSlider');$(document).unbind('mousemove.cpSlider');return false;
        },
        _downSelector:function(e){
            var self=this;this.currentSelector={
                pos:this.picker.find('div.ui-colorpicker-color').offset()
            };this._change.apply(this,[e,this.fields.eq(6).val(parseInt(100*(150-Math.max(0,Math.min(150,(e.pageY-this.currentSelector.pos.top))))/150,10)).end().eq(5).val(parseInt(100*(Math.max(0,Math.min(150,(e.pageX-this.currentSelector.pos.left))))/150,10)).get(0)]);$(document).bind('mouseup.cpSlider',function(e){
                return self._upSelector.call(self,e);
            });$(document).bind('mousemove.cpSlider',function(e){
                return self._moveSelector.call(self,e);
            });return false;
        },
        _moveSelector:function(e){
            this._change.apply(this,[e,this.fields.eq(6).val(parseInt(100*(150-Math.max(0,Math.min(150,(e.pageY-this.currentSelector.pos.top))))/150,10)).end().eq(5).val(parseInt(100*(Math.max(0,Math.min(150,(e.pageX-this.currentSelector.pos.left))))/150,10)).get(0)]);return false;
        },
        _upSelector:function(e){
            $(document).unbind('mouseup.cpSlider');$(document).unbind('mousemove.cpSlider');return false;
        },
        _enterSubmit:function(e){
            this.picker.find('.ui-colorpicker-submit').addClass('ui-colorpicker-focus');
        },
        _leaveSubmit:function(e){
            this.picker.find('.ui-colorpicker-submit').removeClass('ui-colorpicker-focus');
        },
        _clickSubmit:function(e){
            var col=this.color;this.origColor=col;this._setCurrentColor(col);this._trigger("submit",e,{
                options:this.options,
                hsb:col,
                hex:this._HSBToHex(col),
                rgb:this._HSBToRGB(col)
            });return false;
        },
        _show:function(e){
            this._trigger("beforeShow",e,{
                options:this.options,
                hsb:this.color,
                hex:this._HSBToHex(this.color),
                rgb:this._HSBToRGB(this.color)
            });var pos=this.element.offset();var viewPort=this._getScroll();var top=pos.top+this.element[0].offsetHeight;var left=pos.left;if(top+176>viewPort.t+Math.min(viewPort.h,viewPort.ih)){
                top-=this.element[0].offsetHeight+176;
            }
            if(left+356>viewPort.l+Math.min(viewPort.w,viewPort.iw)){
                left-=356;
            }
            this.picker.css({
                left:left+'px',
                top:top+'px'
            });if(this._trigger("show",e,{
                options:this.options,
                hsb:this.color,
                hex:this._HSBToHex(this.color),
                rgb:this._HSBToRGB(this.color)
            })!=false){
                this.picker.show();
            }
            var self=this;$(document).bind('mousedown.colorpicker',function(e){
                return self._hide.call(self,e);
            });return false;
        },
        _hide:function(e){
            if(!this._isChildOf(this.picker[0],e.target,this.picker[0])){
                if(this._trigger("hide",e,{
                    options:this.options,
                    hsb:this.color,
                    hex:this._HSBToHex(this.color),
                    rgb:this._HSBToRGB(this.color)
                })!=false){
                    this.picker.hide();
                }
                $(document).unbind('mousedown.colorpicker');
            }
        },
        _isChildOf:function(parentEl,el,container){
            if(parentEl==el){
                return true;
            }
            if(parentEl.contains&&!$.browser.safari){
                return parentEl.contains(el);
            }
            if(parentEl.compareDocumentPosition){
                return!!(parentEl.compareDocumentPosition(el)&16);
            }
            var prEl=el.parentNode;while(prEl&&prEl!=container){
                if(prEl==parentEl)
                    return true;prEl=prEl.parentNode;
            }
            return false;
        },
        _getScroll:function(){
            var t,l,w,h,iw,ih;if(document.documentElement){
                t=document.documentElement.scrollTop;l=document.documentElement.scrollLeft;w=document.documentElement.scrollWidth;h=document.documentElement.scrollHeight;
            }else{
                t=document.body.scrollTop;l=document.body.scrollLeft;w=document.body.scrollWidth;h=document.body.scrollHeight;
            }
            iw=self.innerWidth||document.documentElement.clientWidth||document.body.clientWidth||0;ih=self.innerHeight||document.documentElement.clientHeight||document.body.clientHeight||0;return{
                t:t,
                l:l,
                w:w,
                h:h,
                iw:iw,
                ih:ih
            };
        },
        _fixHSB:function(hsb){
            return{
                h:Math.min(360,Math.max(0,hsb.h)),
                s:Math.min(100,Math.max(0,hsb.s)),
                b:Math.min(100,Math.max(0,hsb.b))
            };
        },
        _fixRGB:function(rgb){
            return{
                r:Math.min(255,Math.max(0,rgb.r)),
                g:Math.min(255,Math.max(0,rgb.g)),
                b:Math.min(255,Math.max(0,rgb.b))
            };
        },
        _HexToRGB:function(hex){
            var hex=parseInt(((hex.indexOf('#')>-1)?hex.substring(1):hex),16);return{
                r:hex>>16,
                g:(hex&0x00FF00)>>8,
                b:(hex&0x0000FF)
            };
        },
        _HexToHSB:function(hex){
            return this._RGBToHSB(this._HexToRGB(hex));
        },
        _RGBToHSB:function(rgb){
            var hsb={};hsb.b=Math.max(Math.max(rgb.r,rgb.g),rgb.b);hsb.s=(hsb.b<=0)?0:Math.round(100*(hsb.b-Math.min(Math.min(rgb.r,rgb.g),rgb.b))/hsb.b);hsb.b=Math.round((hsb.b/255)*100);if((rgb.r==rgb.g)&&(rgb.g==rgb.b))hsb.h=0;else if(rgb.r>=rgb.g&&rgb.g>=rgb.b)hsb.h=60*(rgb.g-rgb.b)/(rgb.r-rgb.b);else if(rgb.g>=rgb.r&&rgb.r>=rgb.b)hsb.h=60+60*(rgb.g-rgb.r)/(rgb.g-rgb.b);else if(rgb.g>=rgb.b&&rgb.b>=rgb.r)hsb.h=120+60*(rgb.b-rgb.r)/(rgb.g-rgb.r);else if(rgb.b>=rgb.g&&rgb.g>=rgb.r)hsb.h=180+60*(rgb.b-rgb.g)/(rgb.b-rgb.r);else if(rgb.b>=rgb.r&&rgb.r>=rgb.g)hsb.h=240+60*(rgb.r-rgb.g)/(rgb.b-rgb.g);else if(rgb.r>=rgb.b&&rgb.b>=rgb.g)hsb.h=300+60*(rgb.r-rgb.b)/(rgb.r-rgb.g);else hsb.h=0;hsb.h=Math.round(hsb.h);return hsb;
        },
        _HSBToRGB:function(hsb){
            var rgb={};var h=Math.round(hsb.h);var s=Math.round(hsb.s*255/100);var v=Math.round(hsb.b*255/100);if(s==0){
                rgb.r=rgb.g=rgb.b=v;
            }else{
                var t1=v;var t2=(255-s)*v/255;var t3=(t1-t2)*(h%60)/60;if(h==360)h=0;if(h<60){
                    rgb.r=t1;rgb.b=t2;rgb.g=t2+t3;
                }
                else if(h<120){
                    rgb.g=t1;rgb.b=t2;rgb.r=t1-t3;
                }
                else if(h<180){
                    rgb.g=t1;rgb.r=t2;rgb.b=t2+t3;
                }
                else if(h<240){
                    rgb.b=t1;rgb.r=t2;rgb.g=t1-t3;
                }
                else if(h<300){
                    rgb.b=t1;rgb.g=t2;rgb.r=t2+t3;
                }
                else if(h<360){
                    rgb.r=t1;rgb.g=t2;rgb.b=t1-t3;
                }
                else{
                    rgb.r=0;rgb.g=0;rgb.b=0;
                }
            }
            return{
                r:Math.round(rgb.r),
                g:Math.round(rgb.g),
                b:Math.round(rgb.b)
            };
        },
        _RGBToHex:function(rgb){
            var hex=[rgb.r.toString(16),rgb.g.toString(16),rgb.b.toString(16)];$.each(hex,function(nr,val){
                if(val.length==1){
                    hex[nr]='0'+val;
                }
            });return hex.join('');
        },
        _HSBToHex:function(hsb){
            return this._RGBToHex(this._HSBToRGB(hsb));
        },
        setColor:function(col){
            if(typeof col=='string'){
                col=this._HexToHSB(col);
            }else if(col.r!=undefined&&col.g!=undefined&&col.b!=undefined){
                col=this._RGBToHSB(col);
            }else if(col.h!=undefined&&col.s!=undefined&&col.b!=undefined){
                col=this._fixHSB(col);
            }else{
                return this;
            }
            this.color=col;this.origColor=col;this._fillRGBFields(col);this._fillHSBFields(col);this._fillHexFields(col);this._setHue(col);this._setSelector(col);this._setCurrentColor(col);this._setNewColor(col);
        }
    });$.extend($.ui.colorpicker,{
        defaults:{
            eventName:'click',
            color:'ff0000',
            flat:false
        }
    });
})(jQuery);(function($){
    var setDataSwitch={
        dragStart:"start.draggable",
        drag:"drag.draggable",
        dragStop:"stop.draggable",
        maxHeight:"maxHeight.resizable",
        minHeight:"minHeight.resizable",
        maxWidth:"maxWidth.resizable",
        minWidth:"minWidth.resizable",
        resizeStart:"start.resizable",
        resize:"drag.resizable",
        resizeStop:"stop.resizable"
    };$.widget("ui.dialog",{
        _init:function(){
            this.originalTitle=this.element.attr('title');this.options.title=this.options.title||this.originalTitle;var self=this,options=this.options,uiDialogContent=this.element.removeAttr('title').addClass('ui-dialog-content').wrap('<div/>').wrap('<div/>'),uiDialogContainer=(this.uiDialogContainer=uiDialogContent.parent()).addClass('ui-dialog-container').css({
                position:'relative',
                width:'100%',
                height:'100%'
            }),uiDialogTitlebar=(this.uiDialogTitlebar=$('<div/>')).addClass('ui-dialog-titlebar').append('<a href="#" class="ui-dialog-titlebar-close"><span>X</span></a>').prependTo(uiDialogContainer),title=options.title||'&nbsp;',titleId=$.ui.dialog.getTitleId(this.element),uiDialogTitle=$('<span/>').addClass('ui-dialog-title').attr('id',titleId).html(title).prependTo(uiDialogTitlebar),uiDialog=(this.uiDialog=uiDialogContainer.parent()).appendTo(document.body).hide().addClass('ui-dialog').addClass(options.dialogClass).addClass(uiDialogContent.attr('className')).removeClass('ui-dialog-content').css({
                position:'absolute',
                width:options.width,
                height:options.height,
                overflow:'hidden',
                zIndex:options.zIndex
            }).attr('tabIndex',-1).css('outline',0).keydown(function(ev){
                (options.closeOnEscape&&ev.keyCode&&ev.keyCode==$.keyCode.ESCAPE&&self.close());
            }).mousedown(function(){
                self._moveToTop();
            }),uiDialogButtonPane=(this.uiDialogButtonPane=$('<div/>')).addClass('ui-dialog-buttonpane').css({
                position:'absolute',
                bottom:0
            }).appendTo(uiDialog);this.uiDialogTitlebarClose=$('.ui-dialog-titlebar-close',uiDialogTitlebar).hover(function(){
                $(this).addClass('ui-dialog-titlebar-close-hover');
            },function(){
                $(this).removeClass('ui-dialog-titlebar-close-hover');
            }).mousedown(function(ev){
                ev.stopPropagation();
            }).click(function(){
                self.close();return false;
            });uiDialogTitlebar.find("*").add(uiDialogTitlebar).each(function(){
                $.ui.disableSelection(this);
            });(options.draggable&&$.fn.draggable&&this._makeDraggable());(options.resizable&&$.fn.resizable&&this._makeResizable());this._createButtons(options.buttons);this._isOpen=false;(options.bgiframe&&$.fn.bgiframe&&uiDialog.bgiframe());(options.autoOpen&&this.open());
        },
        destroy:function(){
            (this.overlay&&this.overlay.destroy());this.uiDialog.hide();this.element.unbind('.dialog').removeData('dialog').removeClass('ui-dialog-content').hide().appendTo('body');this.uiDialog.remove();(this.originalTitle&&this.element.attr('title',this.originalTitle));
        },
        close:function(){
            if(false===this._trigger('beforeclose',null,{
                options:this.options
            })){
                return;
            }
            (this.overlay&&this.overlay.destroy());this.uiDialog.hide(this.options.hide).unbind('keypress.ui-dialog');this._trigger('close',null,{
                options:this.options
            });$.ui.dialog.overlay.resize();this._isOpen=false;
        },
        isOpen:function(){
            return this._isOpen;
        },
        open:function(){
            if(this._isOpen){
                return;
            }
            this.overlay=this.options.modal?new $.ui.dialog.overlay(this):null;(this.uiDialog.next().length&&this.uiDialog.appendTo('body'));this._position(this.options.position);this.uiDialog.show(this.options.show);(this.options.autoResize&&this._size());this._moveToTop(true);(this.options.modal&&this.uiDialog.bind('keypress.ui-dialog',function(e){
                if(e.keyCode!=$.keyCode.TAB){
                    return;
                }
                var tabbables=$(':tabbable',this),first=tabbables.filter(':first')[0],last=tabbables.filter(':last')[0];if(e.target==last&&!e.shiftKey){
                    setTimeout(function(){
                        first.focus();
                    },1);
                }else if(e.target==first&&e.shiftKey){
                    setTimeout(function(){
                        last.focus();
                    },1);
                }
            }));this.uiDialog.find(':tabbable:first').focus();this._trigger('open',null,{
                options:this.options
            });this._isOpen=true;
        },
        _createButtons:function(buttons){
            var self=this,hasButtons=false,uiDialogButtonPane=this.uiDialogButtonPane;uiDialogButtonPane.empty().hide();$.each(buttons,function(){
                return!(hasButtons=true);
            });if(hasButtons){
                uiDialogButtonPane.show();$.each(buttons,function(name,fn){
                    $('<button type="button"></button>').text(name).click(function(){
                        fn.apply(self.element[0],arguments);
                    }).appendTo(uiDialogButtonPane);
                });
            }
        },
        _makeDraggable:function(){
            var self=this,options=this.options;this.uiDialog.draggable({
                cancel:'.ui-dialog-content',
                helper:options.dragHelper,
                handle:'.ui-dialog-titlebar',
                start:function(){
                    self._moveToTop();(options.dragStart&&options.dragStart.apply(self.element[0],arguments));
                },
                drag:function(){
                    (options.drag&&options.drag.apply(self.element[0],arguments));
                },
                stop:function(){
                    (options.dragStop&&options.dragStop.apply(self.element[0],arguments));$.ui.dialog.overlay.resize();
                }
            });
        },
        _makeResizable:function(handles){
            handles=(handles===undefined?this.options.resizable:handles);var self=this,options=this.options,resizeHandles=typeof handles=='string'?handles:'n,e,s,w,se,sw,ne,nw';this.uiDialog.resizable({
                cancel:'.ui-dialog-content',
                helper:options.resizeHelper,
                maxWidth:options.maxWidth,
                maxHeight:options.maxHeight,
                minWidth:options.minWidth,
                minHeight:options.minHeight,
                start:function(){
                    (options.resizeStart&&options.resizeStart.apply(self.element[0],arguments));
                },
                resize:function(){
                    (options.autoResize&&self._size.apply(self));(options.resize&&options.resize.apply(self.element[0],arguments));
                },
                handles:resizeHandles,
                stop:function(){
                    (options.autoResize&&self._size.apply(self));(options.resizeStop&&options.resizeStop.apply(self.element[0],arguments));$.ui.dialog.overlay.resize();
                }
            });
        },
        _moveToTop:function(force){
            if((this.options.modal&&!force)||(!this.options.stack&&!this.options.modal)){
                return this._trigger('focus',null,{
                    options:this.options
                });
            }
            var maxZ=this.options.zIndex,options=this.options;$('.ui-dialog:visible').each(function(){
                maxZ=Math.max(maxZ,parseInt($(this).css('z-index'),10)||options.zIndex);
            });(this.overlay&&this.overlay.$el.css('z-index',++maxZ));this.uiDialog.css('z-index',++maxZ);this._trigger('focus',null,{
                options:this.options
            });
        },
        _position:function(pos){
            var wnd=$(window),doc=$(document),pTop=doc.scrollTop(),pLeft=doc.scrollLeft(),minTop=pTop;if($.inArray(pos,['center','top','right','bottom','left'])>=0){
                pos=[pos=='right'||pos=='left'?pos:'center',pos=='top'||pos=='bottom'?pos:'middle'];
            }
            if(pos.constructor!=Array){
                pos=['center','middle'];
            }
            if(pos[0].constructor==Number){
                pLeft+=pos[0];
            }else{
                switch(pos[0]){
                    case'left':pLeft+=0;break;case'right':pLeft+=wnd.width()-this.uiDialog.width();break;default:case'center':pLeft+=(wnd.width()-this.uiDialog.width())/2;
                }
            }
            if(pos[1].constructor==Number){
                pTop+=pos[1];
            }else{
                switch(pos[1]){
                    case'top':pTop+=0;break;case'bottom':pTop+=wnd.height()-this.uiDialog.height();break;default:case'middle':pTop+=(wnd.height()-this.uiDialog.height())/2;
                }
            }
            pTop=Math.max(pTop,minTop);this.uiDialog.css({
                top:pTop,
                left:pLeft
            });
        },
        _setData:function(key,value){
            (setDataSwitch[key]&&this.uiDialog.data(setDataSwitch[key],value));switch(key){
                case"buttons":this._createButtons(value);break;case"draggable":(value?this._makeDraggable():this.uiDialog.draggable('destroy'));break;case"height":this.uiDialog.height(value);break;case"position":this._position(value);break;case"resizable":var uiDialog=this.uiDialog,isResizable=this.uiDialog.is(':data(resizable)');(isResizable&&!value&&uiDialog.resizable('destroy'));(isResizable&&typeof value=='string'&&uiDialog.resizable('option','handles',value));(isResizable||this._makeResizable(value));break;case"title":$(".ui-dialog-title",this.uiDialogTitlebar).html(value||'&nbsp;');break;case"width":this.uiDialog.width(value);break;
            }
            $.widget.prototype._setData.apply(this,arguments);
        },
        _size:function(){
            var container=this.uiDialogContainer,titlebar=this.uiDialogTitlebar,content=this.element,tbMargin=(parseInt(content.css('margin-top'),10)||0)
            +(parseInt(content.css('margin-bottom'),10)||0),lrMargin=(parseInt(content.css('margin-left'),10)||0)
            +(parseInt(content.css('margin-right'),10)||0);content.height(container.height()-titlebar.outerHeight()-tbMargin);content.width(container.width()-lrMargin);
        }
    });$.extend($.ui.dialog,{
        defaults:{
            autoOpen:true,
            autoResize:true,
            bgiframe:false,
            buttons:{},
            closeOnEscape:true,
            draggable:true,
            height:200,
            minHeight:100,
            minWidth:150,
            modal:false,
            overlay:{},
            position:'center',
            resizable:true,
            stack:true,
            width:300,
            zIndex:1000
        },
        getter:'isOpen',
        uuid:0,
        getTitleId:function($el){
            return'ui-dialog-title-'+($el.attr('id')||++this.uuid);
        },
        overlay:function(dialog){
            this.$el=$.ui.dialog.overlay.create(dialog);
        }
    });$.extend($.ui.dialog.overlay,{
        instances:[],
        events:$.map('focus,mousedown,mouseup,keydown,keypress,click'.split(','),function(e){
            return e+'.dialog-overlay';
        }).join(' '),
        create:function(dialog){
            if(this.instances.length===0){
                setTimeout(function(){
                    $('a, :input').bind($.ui.dialog.overlay.events,function(){
                        var allow=false;var $dialog=$(this).parents('.ui-dialog');if($dialog.length){
                            var $overlays=$('.ui-dialog-overlay');if($overlays.length){
                                var maxZ=parseInt($overlays.css('z-index'),10);$overlays.each(function(){
                                    maxZ=Math.max(maxZ,parseInt($(this).css('z-index'),10));
                                });allow=parseInt($dialog.css('z-index'),10)>maxZ;
                            }else{
                                allow=true;
                            }
                        }
                        return allow;
                    });
                },1);$(document).bind('keydown.dialog-overlay',function(e){
                    (dialog.options.closeOnEscape&&e.keyCode&&e.keyCode==$.keyCode.ESCAPE&&dialog.close());
                });$(window).bind('resize.dialog-overlay',$.ui.dialog.overlay.resize);
            }
            var $el=$('<div/>').appendTo(document.body).addClass('ui-dialog-overlay').css($.extend({
                borderWidth:0,
                margin:0,
                padding:0,
                position:'absolute',
                top:0,
                left:0,
                width:this.width(),
                height:this.height()
            },dialog.options.overlay));(dialog.options.bgiframe&&$.fn.bgiframe&&$el.bgiframe());this.instances.push($el);return $el;
        },
        destroy:function($el){
            this.instances.splice($.inArray(this.instances,$el),1);if(this.instances.length===0){
                $('a, :input').add([document,window]).unbind('.dialog-overlay');
            }
            $el.remove();
        },
        height:function(){
            if($.browser.msie&&$.browser.version<7){
                var scrollHeight=Math.max(document.documentElement.scrollHeight,document.body.scrollHeight);var offsetHeight=Math.max(document.documentElement.offsetHeight,document.body.offsetHeight);if(scrollHeight<offsetHeight){
                    return $(window).height()+'px';
                }else{
                    return scrollHeight+'px';
                }
            }else if($.browser.opera){
                return Math.max(window.innerHeight,$(document).height())+'px';
            }else{
                return $(document).height()+'px';
            }
        },
        width:function(){
            if($.browser.msie&&$.browser.version<7){
                var scrollWidth=Math.max(document.documentElement.scrollWidth,document.body.scrollWidth);var offsetWidth=Math.max(document.documentElement.offsetWidth,document.body.offsetWidth);if(scrollWidth<offsetWidth){
                    return $(window).width()+'px';
                }else{
                    return scrollWidth+'px';
                }
            }else if($.browser.opera){
                return Math.max(window.innerWidth,$(document).width())+'px';
            }else{
                return $(document).width()+'px';
            }
        },
        resize:function(){
            var $overlays=$([]);$.each($.ui.dialog.overlay.instances,function(){
                $overlays=$overlays.add(this);
            });$overlays.css({
                width:0,
                height:0
            }).css({
                width:$.ui.dialog.overlay.width(),
                height:$.ui.dialog.overlay.height()
            });
        }
    });$.extend($.ui.dialog.overlay.prototype,{
        destroy:function(){
            $.ui.dialog.overlay.destroy(this.$el);
        }
    });
})(jQuery);(function($){
    $.fn.unwrap=$.fn.unwrap||function(expr){
        return this.each(function(){
            $(this).parents(expr).eq(0).after(this).remove();
        });
    };$.widget("ui.slider",{
        plugins:{},
        ui:function(e){
            return{
                options:this.options,
                handle:this.currentHandle,
                value:this.options.axis!="both"||!this.options.axis?Math.round(this.value(null,this.options.axis=="vertical"?"y":"x")):{
                    x:Math.round(this.value(null,"x")),
                    y:Math.round(this.value(null,"y"))
                },
                range:this._getRange()
            };
        },
        _propagate:function(n,e){
            $.ui.plugin.call(this,n,[e,this.ui()]);this.element.triggerHandler(n=="slide"?n:"slide"+n,[e,this.ui()],this.options[n]);
        },
        destroy:function(){
            this.element.removeClass("ui-slider ui-slider-disabled").removeData("slider").unbind(".slider");if(this.handle&&this.handle.length){
                this.handle.unwrap("a");this.handle.each(function(){
                    $(this).data("mouse")._mouseDestroy();
                });
            }
            this.generated&&this.generated.remove();
        },
        _setData:function(key,value){
            $.widget.prototype._setData.apply(this,arguments);if(/min|max|steps/.test(key)){
                this._initBoundaries();
            }
            if(key=="range"){
                value?this.handle.length==2&&this._createRange():this._removeRange();
            }
        },
        _init:function(){
            var self=this;this.element.addClass("ui-slider");this._initBoundaries();this.handle=$(this.options.handle,this.element);if(!this.handle.length){
                self.handle=self.generated=$(self.options.handles||[0]).map(function(){
                    var handle=$("<div/>").addClass("ui-slider-handle").appendTo(self.element);if(this.id)
                        handle.attr("id",this.id);return handle[0];
                });
            }
            var handleclass=function(el){
                this.element=$(el);this.element.data("mouse",this);this.options=self.options;this.element.bind("mousedown",function(){
                    if(self.currentHandle)this.blur(self.currentHandle);self._focus(this,true);
                });this._mouseInit();
            };$.extend(handleclass.prototype,$.ui.mouse,{
                _mouseStart:function(e){
                    return self._start.call(self,e,this.element[0]);
                },
                _mouseStop:function(e){
                    return self._stop.call(self,e,this.element[0]);
                },
                _mouseDrag:function(e){
                    return self._drag.call(self,e,this.element[0]);
                },
                _mouseCapture:function(){
                    return true;
                },
                trigger:function(e){
                    this._mouseDown(e);
                }
            });$(this.handle).each(function(){
                new handleclass(this);
            }).wrap('<a href="#" style="outline:none;border:none;"></a>').parent().bind('click',function(){
                return false;
            }).bind('focus',function(e){
                self._focus(this.firstChild);
            }).bind('blur',function(e){
                self._blur(this.firstChild);
            }).bind('keydown',function(e){
                if(!self.options.noKeyboard)return self._keydown(e.keyCode,this.firstChild);
            });this.element.bind('mousedown.slider',function(e){
                self._click.apply(self,[e]);self.currentHandle.data("mouse").trigger(e);self.firstValue=self.firstValue+1;
            });$.each(this.options.handles||[],function(index,handle){
                self.moveTo(handle.start,index,true);
            });if(!isNaN(this.options.startValue))
                this.moveTo(this.options.startValue,0,true);this.previousHandle=$(this.handle[0]);if(this.handle.length==2&&this.options.range)this._createRange();
        },
        _initBoundaries:function(){
            var element=this.element[0],o=this.options;this.actualSize={
                width:this.element.outerWidth(),
                height:this.element.outerHeight()
            };$.extend(o,{
                axis:o.axis||(element.offsetWidth<element.offsetHeight?'vertical':'horizontal'),
                max:!isNaN(parseInt(o.max,10))?{
                    x:parseInt(o.max,10),
                    y:parseInt(o.max,10)
                }:({
                    x:o.max&&o.max.x||100,
                    y:o.max&&o.max.y||100
                }),
                min:!isNaN(parseInt(o.min,10))?{
                    x:parseInt(o.min,10),
                    y:parseInt(o.min,10)
                }:({
                    x:o.min&&o.min.x||0,
                    y:o.min&&o.min.y||0
                })
            });o.realMax={
                x:o.max.x-o.min.x,
                y:o.max.y-o.min.y
            };o.stepping={
                x:o.stepping&&o.stepping.x||parseInt(o.stepping,10)||(o.steps?o.realMax.x/(o.steps.x||parseInt(o.steps,10)||o.realMax.x):0),
                y:o.stepping&&o.stepping.y||parseInt(o.stepping,10)||(o.steps?o.realMax.y/(o.steps.y||parseInt(o.steps,10)||o.realMax.y):0)
            };
        },
        _keydown:function(keyCode,handle){
            var k=keyCode;if(/(33|34|35|36|37|38|39|40)/.test(k)){
                var o=this.options,xpos,ypos;if(/(35|36)/.test(k)){
                    xpos=(k==35)?o.max.x:o.min.x;ypos=(k==35)?o.max.y:o.min.y;
                }else{
                    var oper=/(34|37|40)/.test(k)?"-=":"+=";var step=/(37|38|39|40)/.test(k)?"_oneStep":"_pageStep";xpos=oper+this[step]("x");ypos=oper+this[step]("y");
                }
                this.moveTo({
                    x:xpos,
                    y:ypos
                },handle);return false;
            }
            return true;
        },
        _focus:function(handle,hard){
            this.currentHandle=$(handle).addClass('ui-slider-handle-active');if(hard)
                this.currentHandle.parent()[0].focus();
        },
        _blur:function(handle){
            $(handle).removeClass('ui-slider-handle-active');if(this.currentHandle&&this.currentHandle[0]==handle){
                this.previousHandle=this.currentHandle;this.currentHandle=null;
            };
        },
        _click:function(e){
            var pointer=[e.pageX,e.pageY];var clickedHandle=false;this.handle.each(function(){
                if(this==e.target)
                    clickedHandle=true;
            });if(clickedHandle||this.options.disabled||!(this.currentHandle||this.previousHandle))
                return;if(!this.currentHandle&&this.previousHandle)
                this._focus(this.previousHandle,true);this.offset=this.element.offset();this.moveTo({
                y:this._convertValue(e.pageY-this.offset.top-this.currentHandle[0].offsetHeight/2,"y"),
                x:this._convertValue(e.pageX-this.offset.left-this.currentHandle[0].offsetWidth/2,"x")
            },null,!this.options.distance);
        },
        _createRange:function(){
            if(this.rangeElement)return;this.rangeElement=$('<div></div>').addClass('ui-slider-range').css({
                position:'absolute'
            }).appendTo(this.element);this._updateRange();
        },
        _removeRange:function(){
            this.rangeElement.remove();this.rangeElement=null;
        },
        _updateRange:function(){
            var prop=this.options.axis=="vertical"?"top":"left";var size=this.options.axis=="vertical"?"height":"width";this.rangeElement.css(prop,(parseInt($(this.handle[0]).css(prop),10)||0)+this._handleSize(0,this.options.axis=="vertical"?"y":"x")/2);this.rangeElement.css(size,(parseInt($(this.handle[1]).css(prop),10)||0)-(parseInt($(this.handle[0]).css(prop),10)||0));
        },
        _getRange:function(){
            return this.rangeElement?this._convertValue(parseInt(this.rangeElement.css(this.options.axis=="vertical"?"height":"width"),10),this.options.axis=="vertical"?"y":"x"):null;
        },
        _handleIndex:function(){
            return this.handle.index(this.currentHandle[0]);
        },
        value:function(handle,axis){
            if(this.handle.length==1)this.currentHandle=this.handle;if(!axis)axis=this.options.axis=="vertical"?"y":"x";var curHandle=$(handle!=undefined&&handle!==null?this.handle[handle]||handle:this.currentHandle);if(curHandle.data("mouse").sliderValue){
                return parseInt(curHandle.data("mouse").sliderValue[axis],10);
            }else{
                return parseInt(((parseInt(curHandle.css(axis=="x"?"left":"top"),10)/(this.actualSize[axis=="x"?"width":"height"]-this._handleSize(handle,axis)))*this.options.realMax[axis])+this.options.min[axis],10);
            }
        },
        _convertValue:function(value,axis){
            return this.options.min[axis]+(value/(this.actualSize[axis=="x"?"width":"height"]-this._handleSize(null,axis)))*this.options.realMax[axis];
        },
        _translateValue:function(value,axis){
            return((value-this.options.min[axis])/this.options.realMax[axis])*(this.actualSize[axis=="x"?"width":"height"]-this._handleSize(null,axis));
        },
        _translateRange:function(value,axis){
            if(this.rangeElement){
                if(this.currentHandle[0]==this.handle[0]&&value>=this._translateValue(this.value(1),axis))
                    value=this._translateValue(this.value(1,axis)-this._oneStep(axis),axis);if(this.currentHandle[0]==this.handle[1]&&value<=this._translateValue(this.value(0),axis))
                    value=this._translateValue(this.value(0,axis)+this._oneStep(axis),axis);
            }
            if(this.options.handles){
                var handle=this.options.handles[this._handleIndex()];if(value<this._translateValue(handle.min,axis)){
                    value=this._translateValue(handle.min,axis);
                }else if(value>this._translateValue(handle.max,axis)){
                    value=this._translateValue(handle.max,axis);
                }
            }
            return value;
        },
        _translateLimits:function(value,axis){
            if(value>=this.actualSize[axis=="x"?"width":"height"]-this._handleSize(null,axis))
                value=this.actualSize[axis=="x"?"width":"height"]-this._handleSize(null,axis);if(value<=0)
                value=0;return value;
        },
        _handleSize:function(handle,axis){
            return $(handle!=undefined&&handle!==null?this.handle[handle]:this.currentHandle)[0]["offset"+(axis=="x"?"Width":"Height")];
        },
        _oneStep:function(axis){
            return this.options.stepping[axis]||1;
        },
        _pageStep:function(axis){
            return 10;
        },
        _start:function(e,handle){
            var o=this.options;if(o.disabled)return false;this.actualSize={
                width:this.element.outerWidth(),
                height:this.element.outerHeight()
            };if(!this.currentHandle)
                this._focus(this.previousHandle,true);this.offset=this.element.offset();this.handleOffset=this.currentHandle.offset();this.clickOffset={
                top:e.pageY-this.handleOffset.top,
                left:e.pageX-this.handleOffset.left
            };this.firstValue=this.value();this._propagate('start',e);this._drag(e,handle);return true;
        },
        _stop:function(e){
            this._propagate('stop',e);if(this.firstValue!=this.value())
                this._propagate('change',e);this._focus(this.currentHandle,true);return false;
        },
        _drag:function(e,handle){
            var o=this.options;var position={
                top:e.pageY-this.offset.top-this.clickOffset.top,
                left:e.pageX-this.offset.left-this.clickOffset.left
            };if(!this.currentHandle)this._focus(this.previousHandle,true);position.left=this._translateLimits(position.left,"x");position.top=this._translateLimits(position.top,"y");if(o.stepping.x){
                var value=this._convertValue(position.left,"x");value=Math.round(value/o.stepping.x)*o.stepping.x;position.left=this._translateValue(value,"x");
            }
            if(o.stepping.y){
                var value=this._convertValue(position.top,"y");value=Math.round(value/o.stepping.y)*o.stepping.y;position.top=this._translateValue(value,"y");
            }
            position.left=this._translateRange(position.left,"x");position.top=this._translateRange(position.top,"y");if(o.axis!="vertical")this.currentHandle.css({
                left:position.left
            });if(o.axis!="horizontal")this.currentHandle.css({
                top:position.top
            });this.currentHandle.data("mouse").sliderValue={
                x:Math.round(this._convertValue(position.left,"x"))||0,
                y:Math.round(this._convertValue(position.top,"y"))||0
            };if(this.rangeElement)
                this._updateRange();this._propagate('slide',e);return false;
        },
        moveTo:function(value,handle,noPropagation){
            var o=this.options;this.actualSize={
                width:this.element.outerWidth(),
                height:this.element.outerHeight()
            };if(handle==undefined&&!this.currentHandle&&this.handle.length!=1)
                return false;if(handle==undefined&&!this.currentHandle)
                handle=0;if(handle!=undefined)
                this.currentHandle=this.previousHandle=$(this.handle[handle]||handle);if(value.x!==undefined&&value.y!==undefined){
                var x=value.x,y=value.y;
            }else{
                var x=value,y=value;
            }
            if(x!==undefined&&x.constructor!=Number){
                var me=/^\-\=/.test(x),pe=/^\+\=/.test(x);if(me||pe){
                    x=this.value(null,"x")+parseInt(x.replace(me?'=':'+=',''),10);
                }else{
                    x=isNaN(parseInt(x,10))?undefined:parseInt(x,10);
                }
            }
            if(y!==undefined&&y.constructor!=Number){
                var me=/^\-\=/.test(y),pe=/^\+\=/.test(y);if(me||pe){
                    y=this.value(null,"y")+parseInt(y.replace(me?'=':'+=',''),10);
                }else{
                    y=isNaN(parseInt(y,10))?undefined:parseInt(y,10);
                }
            }
            if(o.axis!="vertical"&&x!==undefined){
                if(o.stepping.x)x=Math.round(x/o.stepping.x)*o.stepping.x;x=this._translateValue(x,"x");x=this._translateLimits(x,"x");x=this._translateRange(x,"x");o.animate?this.currentHandle.stop().animate({
                    left:x
                },(Math.abs(parseInt(this.currentHandle.css("left"))-x))*(!isNaN(parseInt(o.animate))?o.animate:5)):this.currentHandle.css({
                    left:x
                });
            }
            if(o.axis!="horizontal"&&y!==undefined){
                if(o.stepping.y)y=Math.round(y/o.stepping.y)*o.stepping.y;y=this._translateValue(y,"y");y=this._translateLimits(y,"y");y=this._translateRange(y,"y");o.animate?this.currentHandle.stop().animate({
                    top:y
                },(Math.abs(parseInt(this.currentHandle.css("top"))-y))*(!isNaN(parseInt(o.animate))?o.animate:5)):this.currentHandle.css({
                    top:y
                });
            }
            if(this.rangeElement)
                this._updateRange();this.currentHandle.data("mouse").sliderValue={
                x:Math.round(this._convertValue(x,"x"))||0,
                y:Math.round(this._convertValue(y,"y"))||0
            };if(!noPropagation){
                this._propagate('start',null);this._propagate('stop',null);this._propagate('change',null);this._propagate("slide",null);
            }
        }
    });$.ui.slider.getter="value";$.ui.slider.defaults={
        handle:".ui-slider-handle",
        distance:1,
        animate:false
    };
})(jQuery);(function($){
    $.widget("ui.tabs",{
        _init:function(){
            this.options.event+='.tabs';this._tabify(true);
        },
        _setData:function(key,value){
            if((/^selected/).test(key))
                this.select(value);else{
                this.options[key]=value;this._tabify();
            }
        },
        length:function(){
            return this.$tabs.length;
        },
        _tabId:function(a){
            return a.title&&a.title.replace(/\s/g,'_').replace(/[^A-Za-z0-9\-_:\.]/g,'')||this.options.idPrefix+$.data(a);
        },
        ui:function(tab,panel){
            return{
                options:this.options,
                tab:tab,
                panel:panel,
                index:this.$tabs.index(tab)
            };
        },
        _tabify:function(init){
            this.$lis=$('li:has(a[href])',this.element);this.$tabs=this.$lis.map(function(){
                return $('a',this)[0];
            });this.$panels=$([]);var self=this,o=this.options;this.$tabs.each(function(i,a){
                if(a.hash&&a.hash.replace('#',''))
                    self.$panels=self.$panels.add(a.hash);else if($(a).attr('href')!='#'){
                    $.data(a,'href.tabs',a.href);$.data(a,'load.tabs',a.href);var id=self._tabId(a);a.href='#'+id;var $panel=$('#'+id);if(!$panel.length){
                        $panel=$(o.panelTemplate).attr('id',id).addClass(o.panelClass).insertAfter(self.$panels[i-1]||self.element);$panel.data('destroy.tabs',true);
                    }
                    self.$panels=self.$panels.add($panel);
                }
                else
                    o.disabled.push(i+1);
            });if(init){
                this.element.addClass(o.navClass);this.$panels.each(function(){
                    var $this=$(this);$this.addClass(o.panelClass);
                });if(o.selected===undefined){
                    if(location.hash){
                        this.$tabs.each(function(i,a){
                            if(a.hash==location.hash){
                                o.selected=i;if($.browser.msie||$.browser.opera){
                                    var $toShow=$(location.hash),toShowId=$toShow.attr('id');$toShow.attr('id','');setTimeout(function(){
                                        $toShow.attr('id',toShowId);
                                    },500);
                                }
                                scrollTo(0,0);return false;
                            }
                        });
                    }
                    else if(o.cookie){
                        var index=parseInt($.cookie('ui-tabs-'+$.data(self.element[0])),10);if(index&&self.$tabs[index])
                            o.selected=index;
                    }
                    else if(self.$lis.filter('.'+o.selectedClass).length)
                        o.selected=self.$lis.index(self.$lis.filter('.'+o.selectedClass)[0]);
                }
                o.selected=o.selected===null||o.selected!==undefined?o.selected:0;o.disabled=$.unique(o.disabled.concat($.map(this.$lis.filter('.'+o.disabledClass),function(n,i){
                    return self.$lis.index(n);
                }))).sort();if($.inArray(o.selected,o.disabled)!=-1)
                    o.disabled.splice($.inArray(o.selected,o.disabled),1);this.$panels.addClass(o.hideClass);this.$lis.removeClass(o.selectedClass);if(o.selected!==null){
                    this.$panels.eq(o.selected).show().removeClass(o.hideClass);this.$lis.eq(o.selected).addClass(o.selectedClass);var onShow=function(){
                        self._trigger('show',null,self.ui(self.$tabs[o.selected],self.$panels[o.selected]));
                    };if($.data(this.$tabs[o.selected],'load.tabs'))
                        this.load(o.selected,onShow);else
                        onShow();
                }
                $(window).bind('unload',function(){
                    self.$tabs.unbind('.tabs');self.$lis=self.$tabs=self.$panels=null;
                });
            }
            else
                o.selected=this.$lis.index(this.$lis.filter('.'+o.selectedClass)[0]);if(o.cookie)
                $.cookie('ui-tabs-'+$.data(self.element[0]),o.selected,o.cookie);for(var i=0,li;li=this.$lis[i];i++)
                $(li)[$.inArray(i,o.disabled)!=-1&&!$(li).hasClass(o.selectedClass)?'addClass':'removeClass'](o.disabledClass);if(o.cache===false)
                this.$tabs.removeData('cache.tabs');var hideFx,showFx,baseFx={
                'min-width':0,
                duration:1
            },baseDuration='normal';if(o.fx&&o.fx.constructor==Array)
                hideFx=o.fx[0]||baseFx,showFx=o.fx[1]||baseFx;else
                hideFx=showFx=o.fx||baseFx;var resetCSS={
                display:'',
                overflow:'',
                height:''
            };if(!$.browser.msie)
                resetCSS.opacity='';function hideTab(clicked,$hide,$show){
                $hide.animate(hideFx,hideFx.duration||baseDuration,function(){
                    $hide.addClass(o.hideClass).css(resetCSS);if($.browser.msie&&hideFx.opacity)
                        $hide[0].style.filter='';if($show)
                        showTab(clicked,$show,$hide);
                });
            }
            function showTab(clicked,$show,$hide){
                if(showFx===baseFx)
                    $show.css('display','block');$show.animate(showFx,showFx.duration||baseDuration,function(){
                    $show.removeClass(o.hideClass).css(resetCSS);if($.browser.msie&&showFx.opacity)
                        $show[0].style.filter='';self._trigger('show',null,self.ui(clicked,$show[0]));
                });
            }
            function switchTab(clicked,$li,$hide,$show){
                $li.addClass(o.selectedClass).siblings().removeClass(o.selectedClass);hideTab(clicked,$hide,$show);
            }
            this.$tabs.unbind('.tabs').bind(o.event,function(){
                var $li=$(this).parents('li:eq(0)'),$hide=self.$panels.filter(':visible'),$show=$(this.hash);if(($li.hasClass(o.selectedClass)&&!o.unselect)||$li.hasClass(o.disabledClass)||$(this).hasClass(o.loadingClass)||self._trigger('select',null,self.ui(this,$show[0]))===false){
                    this.blur();return false;
                }
                self.options.selected=self.$tabs.index(this);if(o.unselect){
                    if($li.hasClass(o.selectedClass)){
                        self.options.selected=null;$li.removeClass(o.selectedClass);self.$panels.stop();hideTab(this,$hide);this.blur();return false;
                    }else if(!$hide.length){
                        self.$panels.stop();var a=this;self.load(self.$tabs.index(this),function(){
                            $li.addClass(o.selectedClass).addClass(o.unselectClass);showTab(a,$show);
                        });this.blur();return false;
                    }
                }
                if(o.cookie)
                    $.cookie('ui-tabs-'+$.data(self.element[0]),self.options.selected,o.cookie);self.$panels.stop();if($show.length){
                    var a=this;self.load(self.$tabs.index(this),$hide.length?function(){
                        switchTab(a,$li,$hide,$show);
                    }:function(){
                        $li.addClass(o.selectedClass);showTab(a,$show);
                    });
                }else
                    throw'jQuery UI Tabs: Mismatching fragment identifier.';if($.browser.msie)
                    this.blur();return false;
            });if(!(/^click/).test(o.event))
                this.$tabs.bind('click.tabs',function(){
                    return false;
                });
        },
        add:function(url,label,index){
            if(index==undefined)
                index=this.$tabs.length;var o=this.options;var $li=$(o.tabTemplate.replace(/#\{href\}/g,url).replace(/#\{label\}/g,label));$li.data('destroy.tabs',true);var id=url.indexOf('#')==0?url.replace('#',''):this._tabId($('a:first-child',$li)[0]);var $panel=$('#'+id);if(!$panel.length){
                $panel=$(o.panelTemplate).attr('id',id).addClass(o.hideClass).data('destroy.tabs',true);
            }
            $panel.addClass(o.panelClass);if(index>=this.$lis.length){
                $li.appendTo(this.element);$panel.appendTo(this.element[0].parentNode);
            }else{
                $li.insertBefore(this.$lis[index]);$panel.insertBefore(this.$panels[index]);
            }
            o.disabled=$.map(o.disabled,function(n,i){
                return n>=index?++n:n
            });this._tabify();if(this.$tabs.length==1){
                $li.addClass(o.selectedClass);$panel.removeClass(o.hideClass);var href=$.data(this.$tabs[0],'load.tabs');if(href)
                    this.load(index,href);
            }
            this._trigger('add',null,this.ui(this.$tabs[index],this.$panels[index]));
        },
        remove:function(index){
            var o=this.options,$li=this.$lis.eq(index).remove(),$panel=this.$panels.eq(index).remove();if($li.hasClass(o.selectedClass)&&this.$tabs.length>1)
                this.select(index+(index+1<this.$tabs.length?1:-1));o.disabled=$.map($.grep(o.disabled,function(n,i){
                return n!=index;
            }),function(n,i){
                return n>=index?--n:n
            });this._tabify();this._trigger('remove',null,this.ui($li.find('a')[0],$panel[0]));
        },
        enable:function(index){
            var o=this.options;if($.inArray(index,o.disabled)==-1)
                return;var $li=this.$lis.eq(index).removeClass(o.disabledClass);if($.browser.safari){
                $li.css('display','inline-block');setTimeout(function(){
                    $li.css('display','block');
                },0);
            }
            o.disabled=$.grep(o.disabled,function(n,i){
                return n!=index;
            });this._trigger('enable',null,this.ui(this.$tabs[index],this.$panels[index]));
        },
        disable:function(index){
            var self=this,o=this.options;if(index!=o.selected){
                this.$lis.eq(index).addClass(o.disabledClass);o.disabled.push(index);o.disabled.sort();this._trigger('disable',null,this.ui(this.$tabs[index],this.$panels[index]));
            }
        },
        select:function(index){
            if(typeof index=='string')
                index=this.$tabs.index(this.$tabs.filter('[href$='+index+']')[0]);this.$tabs.eq(index).trigger(this.options.event);
        },
        load:function(index,callback){
            var self=this,o=this.options,$a=this.$tabs.eq(index),a=$a[0],bypassCache=callback==undefined||callback===false,url=$a.data('load.tabs');callback=callback||function(){};if(!url||!bypassCache&&$.data(a,'cache.tabs')){
                callback();return;
            }
            var inner=function(parent){
                var $parent=$(parent),$inner=$parent.find('*:last');return $inner.length&&$inner.is(':not(img)')&&$inner||$parent;
            };var cleanup=function(){
                self.$tabs.filter('.'+o.loadingClass).removeClass(o.loadingClass).each(function(){
                    if(o.spinner)
                        inner(this).parent().html(inner(this).data('label.tabs'));
                });self.xhr=null;
            };if(o.spinner){
                var label=inner(a).html();inner(a).wrapInner('<em></em>').find('em').data('label.tabs',label).html(o.spinner);
            }
            var ajaxOptions=$.extend({},o.ajaxOptions,{
                url:url,
                success:function(r,s){
                    $(a.hash).html(r);cleanup();if(o.cache)
                        $.data(a,'cache.tabs',true);self._trigger('load',null,self.ui(self.$tabs[index],self.$panels[index]));o.ajaxOptions.success&&o.ajaxOptions.success(r,s);callback();
                }
            });if(this.xhr){
                this.xhr.abort();cleanup();
            }
            $a.addClass(o.loadingClass);setTimeout(function(){
                self.xhr=$.ajax(ajaxOptions);
            },0);
        },
        url:function(index,url){
            this.$tabs.eq(index).removeData('cache.tabs').data('load.tabs',url);
        },
        destroy:function(){
            var o=this.options;this.element.unbind('.tabs').removeClass(o.navClass).removeData('tabs');this.$tabs.each(function(){
                var href=$.data(this,'href.tabs');if(href)
                    this.href=href;var $this=$(this).unbind('.tabs');$.each(['href','load','cache'],function(i,prefix){
                    $this.removeData(prefix+'.tabs');
                });
            });this.$lis.add(this.$panels).each(function(){
                if($.data(this,'destroy.tabs'))
                    $(this).remove();else
                    $(this).removeClass([o.selectedClass,o.unselectClass,o.disabledClass,o.panelClass,o.hideClass].join(' '));
            });
        }
    });$.ui.tabs.defaults={
        unselect:false,
        event:'click',
        disabled:[],
        cookie:null,
        spinner:'Loading&#8230;',
        cache:false,
        idPrefix:'ui-tabs-',
        ajaxOptions:{},
        fx:null,
        tabTemplate:'<li><a href="#{href}"><span>#{label}</span></a></li>',
        panelTemplate:'<div></div>',
        navClass:'ui-tabs-nav',
        selectedClass:'ui-tabs-selected',
        unselectClass:'ui-tabs-unselect',
        disabledClass:'ui-tabs-disabled',
        panelClass:'ui-tabs-panel',
        hideClass:'ui-tabs-hide',
        loadingClass:'ui-tabs-loading'
    };$.ui.tabs.getter="length";$.extend($.ui.tabs.prototype,{
        rotation:null,
        rotate:function(ms,continuing){
            continuing=continuing||false;var self=this,t=this.options.selected;function start(){
                self.rotation=setInterval(function(){
                    t=++t<self.$tabs.length?t:0;self.select(t);
                },ms);
            }
            function stop(e){
                if(!e||e.clientX){
                    clearInterval(self.rotation);
                }
            }
            if(ms){
                start();if(!continuing)
                    this.$tabs.bind(this.options.event,stop);else
                    this.$tabs.bind(this.options.event,function(){
                        stop();t=self.options.selected;start();
                    });
            }
            else{
                stop();this.$tabs.unbind(this.options.event,stop);
            }
        }
    });
})(jQuery);(function($){
    var PROP_NAME='datepicker';function Datepicker(){
        this.debug=false;this._curInst=null;this._disabledInputs=[];this._datepickerShowing=false;this._inDialog=false;this._mainDivId='ui-datepicker-div';this._inlineClass='ui-datepicker-inline';this._appendClass='ui-datepicker-append';this._triggerClass='ui-datepicker-trigger';this._dialogClass='ui-datepicker-dialog';this._promptClass='ui-datepicker-prompt';this._disableClass='ui-datepicker-disabled';this._unselectableClass='ui-datepicker-unselectable';this._currentClass='ui-datepicker-current-day';this.regional=[];this.regional['']={
            clearText:'Clear',
            clearStatus:'Erase the current date',
            closeText:'Close',
            closeStatus:'Close without change',
            prevText:'&#x3c;Prev',
            prevStatus:'Show the previous month',
            prevBigText:'&#x3c;&#x3c;',
            prevBigStatus:'Show the previous year',
            nextText:'Next&#x3e;',
            nextStatus:'Show the next month',
            nextBigText:'&#x3e;&#x3e;',
            nextBigStatus:'Show the next year',
            currentText:'Today',
            currentStatus:'Show the current month',
            monthNames:['January','February','March','April','May','June','July','August','September','October','November','December'],
            monthNamesShort:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            monthStatus:'Show a different month',
            yearStatus:'Show a different year',
            weekHeader:'Wk',
            weekStatus:'Week of the year',
            dayNames:['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
            dayNamesShort:['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],
            dayNamesMin:['Su','Mo','Tu','We','Th','Fr','Sa'],
            dayStatus:'Set DD as first week day',
            dateStatus:'Select DD, M d',
            dateFormat:'mm/dd/yy',
            firstDay:0,
            initStatus:'Select a date',
            isRTL:false
        };this._defaults={
            showOn:'focus',
            showAnim:'show',
            showOptions:{},
            defaultDate:null,
            appendText:'',
            buttonText:'...',
            buttonImage:'',
            buttonImageOnly:false,
            closeAtTop:true,
            mandatory:false,
            hideIfNoPrevNext:false,
            navigationAsDateFormat:false,
            showBigPrevNext:false,
            gotoCurrent:false,
            changeMonth:true,
            changeYear:true,
            showMonthAfterYear:false,
            yearRange:'-10:+10',
            changeFirstDay:true,
            highlightWeek:false,
            showOtherMonths:false,
            showWeeks:false,
            calculateWeek:this.iso8601Week,
            shortYearCutoff:'+10',
            showStatus:false,
            statusForDate:this.dateStatus,
            minDate:null,
            maxDate:null,
            duration:'normal',
            beforeShowDay:null,
            beforeShow:null,
            onSelect:null,
            onChangeMonthYear:null,
            onClose:null,
            numberOfMonths:1,
            showCurrentAtPos:0,
            stepMonths:1,
            stepBigMonths:12,
            rangeSelect:false,
            rangeSeparator:' - ',
            altField:'',
            altFormat:''
        };$.extend(this._defaults,this.regional['']);this.dpDiv=$('<div id="'+this._mainDivId+'" style="display: none;"></div>');
    }
    $.extend(Datepicker.prototype,{
        markerClassName:'hasDatepicker',
        log:function(){
            if(this.debug)
                console.log.apply('',arguments);
        },
        setDefaults:function(settings){
            extendRemove(this._defaults,settings||{});return this;
        },
        _attachDatepicker:function(target,settings){
            var inlineSettings=null;for(attrName in this._defaults){
                var attrValue=target.getAttribute('date:'+attrName);if(attrValue){
                    inlineSettings=inlineSettings||{};try{
                        inlineSettings[attrName]=eval(attrValue);
                    }catch(err){
                        inlineSettings[attrName]=attrValue;
                    }
                }
            }
            var nodeName=target.nodeName.toLowerCase();var inline=(nodeName=='div'||nodeName=='span');if(!target.id)
                target.id='dp'+(++this.uuid);var inst=this._newInst($(target),inline);inst.settings=$.extend({},settings||{},inlineSettings||{});if(nodeName=='input'){
                this._connectDatepicker(target,inst);
            }else if(inline){
                this._inlineDatepicker(target,inst);
            }
        },
        _newInst:function(target,inline){
            var id=target[0].id.replace(/([:\[\]\.])/g,'\\\\$1');return{
                id:id,
                input:target,
                selectedDay:0,
                selectedMonth:0,
                selectedYear:0,
                drawMonth:0,
                drawYear:0,
                inline:inline,
                dpDiv:(!inline?this.dpDiv:$('<div class="'+this._inlineClass+'"></div>'))
            };
        },
        _connectDatepicker:function(target,inst){
            var input=$(target);if(input.hasClass(this.markerClassName))
                return;var appendText=this._get(inst,'appendText');var isRTL=this._get(inst,'isRTL');if(appendText)
                input[isRTL?'before':'after']('<span class="'+this._appendClass+'">'+appendText+'</span>');var showOn=this._get(inst,'showOn');if(showOn=='focus'||showOn=='both')
                input.focus(this._showDatepicker);if(showOn=='button'||showOn=='both'){
                var buttonText=this._get(inst,'buttonText');var buttonImage=this._get(inst,'buttonImage');var trigger=$(this._get(inst,'buttonImageOnly')?$('<img/>').addClass(this._triggerClass).attr({
                    src:buttonImage,
                    alt:buttonText,
                    title:buttonText
                }):$('<button type="button"></button>').addClass(this._triggerClass).html(buttonImage==''?buttonText:$('<img/>').attr({
                    src:buttonImage,
                    alt:buttonText,
                    title:buttonText
                })));input[isRTL?'before':'after'](trigger);trigger.click(function(){
                    if($.datepicker._datepickerShowing&&$.datepicker._lastInput==target)
                        $.datepicker._hideDatepicker();else
                        $.datepicker._showDatepicker(target);return false;
                });
            }
            input.addClass(this.markerClassName).keydown(this._doKeyDown).keypress(this._doKeyPress).bind("setData.datepicker",function(event,key,value){
                inst.settings[key]=value;
            }).bind("getData.datepicker",function(event,key){
                return this._get(inst,key);
            });$.data(target,PROP_NAME,inst);
        },
        _inlineDatepicker:function(target,inst){
            var divSpan=$(target);if(divSpan.hasClass(this.markerClassName))
                return;divSpan.addClass(this.markerClassName).append(inst.dpDiv).bind("setData.datepicker",function(event,key,value){
                inst.settings[key]=value;
            }).bind("getData.datepicker",function(event,key){
                return this._get(inst,key);
            });$.data(target,PROP_NAME,inst);this._setDate(inst,this._getDefaultDate(inst));this._updateDatepicker(inst);
        },
        _inlineShow:function(inst){
            var numMonths=this._getNumberOfMonths(inst);inst.dpDiv.width(numMonths[1]*$('.ui-datepicker',inst.dpDiv[0]).width());
        },
        _dialogDatepicker:function(input,dateText,onSelect,settings,pos){
            var inst=this._dialogInst;if(!inst){
                var id='dp'+(++this.uuid);this._dialogInput=$('<input type="text" id="'+id+'" size="1" style="position: absolute; top: -100px;"/>');this._dialogInput.keydown(this._doKeyDown);$('body').append(this._dialogInput);inst=this._dialogInst=this._newInst(this._dialogInput,false);inst.settings={};$.data(this._dialogInput[0],PROP_NAME,inst);
            }
            extendRemove(inst.settings,settings||{});this._dialogInput.val(dateText);this._pos=(pos?(pos.length?pos:[pos.pageX,pos.pageY]):null);if(!this._pos){
                var browserWidth=window.innerWidth||document.documentElement.clientWidth||document.body.clientWidth;var browserHeight=window.innerHeight||document.documentElement.clientHeight||document.body.clientHeight;var scrollX=document.documentElement.scrollLeft||document.body.scrollLeft;var scrollY=document.documentElement.scrollTop||document.body.scrollTop;this._pos=[(browserWidth/2)-100+scrollX,(browserHeight/2)-150+scrollY];
            }
            this._dialogInput.css('left',this._pos[0]+'px').css('top',this._pos[1]+'px');inst.settings.onSelect=onSelect;this._inDialog=true;this.dpDiv.addClass(this._dialogClass);this._showDatepicker(this._dialogInput[0]);if($.blockUI)
                $.blockUI(this.dpDiv);$.data(this._dialogInput[0],PROP_NAME,inst);return this;
        },
        _destroyDatepicker:function(target){
            var $target=$(target);if(!$target.hasClass(this.markerClassName)){
                return;
            }
            var nodeName=target.nodeName.toLowerCase();$.removeData(target,PROP_NAME);if(nodeName=='input'){
                $target.siblings('.'+this._appendClass).remove().end().siblings('.'+this._triggerClass).remove().end().removeClass(this.markerClassName).unbind('focus',this._showDatepicker).unbind('keydown',this._doKeyDown).unbind('keypress',this._doKeyPress);
            }else if(nodeName=='div'||nodeName=='span')
                $target.removeClass(this.markerClassName).empty();
        },
        _enableDatepicker:function(target){
            var $target=$(target);if(!$target.hasClass(this.markerClassName)){
                return;
            }
            var nodeName=target.nodeName.toLowerCase();if(nodeName=='input'){
                target.disabled=false;$target.siblings('button.'+this._triggerClass).each(function(){
                    this.disabled=false;
                }).end().siblings('img.'+this._triggerClass).css({
                    opacity:'1.0',
                    cursor:''
                });
            }
            else if(nodeName=='div'||nodeName=='span'){
                $target.children('.'+this._disableClass).remove();
            }
            this._disabledInputs=$.map(this._disabledInputs,function(value){
                return(value==target?null:value);
            });
        },
        _disableDatepicker:function(target){
            var $target=$(target);if(!$target.hasClass(this.markerClassName)){
                return;
            }
            var nodeName=target.nodeName.toLowerCase();if(nodeName=='input'){
                target.disabled=true;$target.siblings('button.'+this._triggerClass).each(function(){
                    this.disabled=true;
                }).end().siblings('img.'+this._triggerClass).css({
                    opacity:'0.5',
                    cursor:'default'
                });
            }
            else if(nodeName=='div'||nodeName=='span'){
                var inline=$target.children('.'+this._inlineClass);var offset=inline.offset();var relOffset={
                    left:0,
                    top:0
                };inline.parents().each(function(){
                    if($(this).css('position')=='relative'){
                        relOffset=$(this).offset();return false;
                    }
                });$target.prepend('<div class="'+this._disableClass+'" style="'+
                    ($.browser.msie?'background-color: transparent; ':'')+'width: '+inline.width()+'px; height: '+inline.height()+'px; left: '+(offset.left-relOffset.left)+'px; top: '+(offset.top-relOffset.top)+'px;"></div>');
            }
            this._disabledInputs=$.map(this._disabledInputs,function(value){
                return(value==target?null:value);
            });this._disabledInputs[this._disabledInputs.length]=target;
        },
        _isDisabledDatepicker:function(target){
            if(!target)
                return false;for(var i=0;i<this._disabledInputs.length;i++){
                if(this._disabledInputs[i]==target)
                    return true;
            }
            return false;
        },
        _getInst:function(target){
            try{
                return $.data(target,PROP_NAME);
            }
            catch(err){
                throw'Missing instance data for this datepicker';
            }
        },
        _changeDatepicker:function(target,name,value){
            var settings=name||{};if(typeof name=='string'){
                settings={};settings[name]=value;
            }
            var inst=this._getInst(target);if(inst){
                if(this._curInst==inst){
                    this._hideDatepicker(null);
                }
                extendRemove(inst.settings,settings);var date=new Date();extendRemove(inst,{
                    rangeStart:null,
                    endDay:null,
                    endMonth:null,
                    endYear:null,
                    selectedDay:date.getDate(),
                    selectedMonth:date.getMonth(),
                    selectedYear:date.getFullYear(),
                    currentDay:date.getDate(),
                    currentMonth:date.getMonth(),
                    currentYear:date.getFullYear(),
                    drawMonth:date.getMonth(),
                    drawYear:date.getFullYear()
                });this._updateDatepicker(inst);
            }
        },
        _refreshDatepicker:function(target){
            var inst=this._getInst(target);if(inst){
                this._updateDatepicker(inst);
            }
        },
        _setDateDatepicker:function(target,date,endDate){
            var inst=this._getInst(target);if(inst){
                this._setDate(inst,date,endDate);this._updateDatepicker(inst);this._updateAlternate(inst);
            }
        },
        _getDateDatepicker:function(target){
            var inst=this._getInst(target);if(inst&&!inst.inline)
                this._setDateFromField(inst);return(inst?this._getDate(inst):null);
        },
        _doKeyDown:function(e){
            var inst=$.datepicker._getInst(e.target);var handled=true;if($.datepicker._datepickerShowing)
                switch(e.keyCode){
                    case 9:$.datepicker._hideDatepicker(null,'');break;case 13:$.datepicker._selectDay(e.target,inst.selectedMonth,inst.selectedYear,$('td.ui-datepicker-days-cell-over',inst.dpDiv)[0]);return false;break;case 27:$.datepicker._hideDatepicker(null,$.datepicker._get(inst,'duration'));break;case 33:$.datepicker._adjustDate(e.target,(e.ctrlKey?-$.datepicker._get(inst,'stepBigMonths'):-$.datepicker._get(inst,'stepMonths')),'M');break;case 34:$.datepicker._adjustDate(e.target,(e.ctrlKey?+$.datepicker._get(inst,'stepBigMonths'):+$.datepicker._get(inst,'stepMonths')),'M');break;case 35:if(e.ctrlKey)$.datepicker._clearDate(e.target);handled=e.ctrlKey;break;case 36:if(e.ctrlKey)$.datepicker._gotoToday(e.target);handled=e.ctrlKey;break;case 37:if(e.ctrlKey)$.datepicker._adjustDate(e.target,-1,'D');handled=e.ctrlKey;break;case 38:if(e.ctrlKey)$.datepicker._adjustDate(e.target,-7,'D');handled=e.ctrlKey;break;case 39:if(e.ctrlKey)$.datepicker._adjustDate(e.target,+1,'D');handled=e.ctrlKey;break;case 40:if(e.ctrlKey)$.datepicker._adjustDate(e.target,+7,'D');handled=e.ctrlKey;break;default:handled=false;
                }
            else if(e.keyCode==36&&e.ctrlKey)
                $.datepicker._showDatepicker(this);else
                handled=false;if(handled){
                e.preventDefault();e.stopPropagation();
            }
        },
        _doKeyPress:function(e){
            var inst=$.datepicker._getInst(e.target);var chars=$.datepicker._possibleChars($.datepicker._get(inst,'dateFormat'));var chr=String.fromCharCode(e.charCode==undefined?e.keyCode:e.charCode);return e.ctrlKey||(chr<' '||!chars||chars.indexOf(chr)>-1);
        },
        _showDatepicker:function(input){
            input=input.target||input;if(input.nodeName.toLowerCase()!='input')
                input=$('input',input.parentNode)[0];if($.datepicker._isDisabledDatepicker(input)||$.datepicker._lastInput==input)
                return;var inst=$.datepicker._getInst(input);var beforeShow=$.datepicker._get(inst,'beforeShow');extendRemove(inst.settings,(beforeShow?beforeShow.apply(input,[input,inst]):{}));$.datepicker._hideDatepicker(null,'');$.datepicker._lastInput=input;$.datepicker._setDateFromField(inst);if($.datepicker._inDialog)
                input.value='';if(!$.datepicker._pos){
                $.datepicker._pos=$.datepicker._findPos(input);$.datepicker._pos[1]+=input.offsetHeight;
            }
            var isFixed=false;$(input).parents().each(function(){
                isFixed|=$(this).css('position')=='fixed';return!isFixed;
            });if(isFixed&&$.browser.opera){
                $.datepicker._pos[0]-=document.documentElement.scrollLeft;$.datepicker._pos[1]-=document.documentElement.scrollTop;
            }
            var offset={
                left:$.datepicker._pos[0],
                top:$.datepicker._pos[1]
            };$.datepicker._pos=null;inst.rangeStart=null;inst.dpDiv.css({
                position:'absolute',
                display:'block',
                top:'-1000px'
            });$.datepicker._updateDatepicker(inst);inst.dpDiv.width($.datepicker._getNumberOfMonths(inst)[1]*$('.ui-datepicker',inst.dpDiv[0])[0].offsetWidth);offset=$.datepicker._checkOffset(inst,offset,isFixed);inst.dpDiv.css({
                position:($.datepicker._inDialog&&$.blockUI?'static':(isFixed?'fixed':'absolute')),
                display:'none',
                left:offset.left+'px',
                top:offset.top+'px'
            });if(!inst.inline){
                var showAnim=$.datepicker._get(inst,'showAnim')||'show';var duration=$.datepicker._get(inst,'duration');var postProcess=function(){
                    $.datepicker._datepickerShowing=true;if($.browser.msie&&parseInt($.browser.version,10)<7)
                        $('iframe.ui-datepicker-cover').css({
                            width:inst.dpDiv.width()+4,
                            height:inst.dpDiv.height()+4
                        });
                };if($.effects&&$.effects[showAnim])
                    inst.dpDiv.show(showAnim,$.datepicker._get(inst,'showOptions'),duration,postProcess);else
                    inst.dpDiv[showAnim](duration,postProcess);if(duration=='')
                    postProcess();if(inst.input[0].type!='hidden')
                    inst.input[0].focus();$.datepicker._curInst=inst;
            }
        },
        _updateDatepicker:function(inst){
            var dims={
                width:inst.dpDiv.width()+4,
                height:inst.dpDiv.height()+4
            };inst.dpDiv.empty().append(this._generateHTML(inst)).find('iframe.ui-datepicker-cover').css({
                width:dims.width,
                height:dims.height
            });var numMonths=this._getNumberOfMonths(inst);inst.dpDiv[(numMonths[0]!=1||numMonths[1]!=1?'add':'remove')+'Class']('ui-datepicker-multi');inst.dpDiv[(this._get(inst,'isRTL')?'add':'remove')+'Class']('ui-datepicker-rtl');if(inst.input&&inst.input[0].type!='hidden')
                $(inst.input[0]).focus();
        },
        _checkOffset:function(inst,offset,isFixed){
            var pos=inst.input?this._findPos(inst.input[0]):null;var browserWidth=window.innerWidth||document.documentElement.clientWidth;var browserHeight=window.innerHeight||document.documentElement.clientHeight;var scrollX=document.documentElement.scrollLeft||document.body.scrollLeft;var scrollY=document.documentElement.scrollTop||document.body.scrollTop;if(this._get(inst,'isRTL')||(offset.left+inst.dpDiv.width()-scrollX)>browserWidth)
                offset.left=Math.max((isFixed?0:scrollX),pos[0]+(inst.input?inst.input.width():0)-(isFixed?scrollX:0)-inst.dpDiv.width()-
                    (isFixed&&$.browser.opera?document.documentElement.scrollLeft:0));else
                offset.left-=(isFixed?scrollX:0);if((offset.top+inst.dpDiv.height()-scrollY)>browserHeight)
                offset.top=Math.max((isFixed?0:scrollY),pos[1]-(isFixed?scrollY:0)-(this._inDialog?0:inst.dpDiv.height())-
                    (isFixed&&$.browser.opera?document.documentElement.scrollTop:0));else
                offset.top-=(isFixed?scrollY:0);return offset;
        },
        _findPos:function(obj){
            while(obj&&(obj.type=='hidden'||obj.nodeType!=1)){
                obj=obj.nextSibling;
            }
            var position=$(obj).offset();return[position.left,position.top];
        },
        _hideDatepicker:function(input,duration){
            var inst=this._curInst;if(!inst||(input&&inst!=$.data(input,PROP_NAME)))
                return;var rangeSelect=this._get(inst,'rangeSelect');if(rangeSelect&&inst.stayOpen)
                this._selectDate('#'+inst.id,this._formatDate(inst,inst.currentDay,inst.currentMonth,inst.currentYear));inst.stayOpen=false;if(this._datepickerShowing){
                duration=(duration!=null?duration:this._get(inst,'duration'));var showAnim=this._get(inst,'showAnim');var postProcess=function(){
                    $.datepicker._tidyDialog(inst);
                };if(duration!=''&&$.effects&&$.effects[showAnim])
                    inst.dpDiv.hide(showAnim,$.datepicker._get(inst,'showOptions'),duration,postProcess);else
                    inst.dpDiv[(duration==''?'hide':(showAnim=='slideDown'?'slideUp':(showAnim=='fadeIn'?'fadeOut':'hide')))](duration,postProcess);if(duration=='')
                    this._tidyDialog(inst);var onClose=this._get(inst,'onClose');if(onClose)
                    onClose.apply((inst.input?inst.input[0]:null),[(inst.input?inst.input.val():''),inst]);this._datepickerShowing=false;this._lastInput=null;inst.settings.prompt=null;if(this._inDialog){
                    this._dialogInput.css({
                        position:'absolute',
                        left:'0',
                        top:'-100px'
                    });if($.blockUI){
                        $.unblockUI();$('body').append(this.dpDiv);
                    }
                }
                this._inDialog=false;
            }
            this._curInst=null;
        },
        _tidyDialog:function(inst){
            inst.dpDiv.removeClass(this._dialogClass).unbind('.ui-datepicker');$('.'+this._promptClass,inst.dpDiv).remove();
        },
        _checkExternalClick:function(event){
            if(!$.datepicker._curInst)
                return;var $target=$(event.target);if(($target.parents('#'+$.datepicker._mainDivId).length==0)&&!$target.hasClass($.datepicker.markerClassName)&&!$target.hasClass($.datepicker._triggerClass)&&$.datepicker._datepickerShowing&&!($.datepicker._inDialog&&$.blockUI))
                $.datepicker._hideDatepicker(null,'');
        },
        _adjustDate:function(id,offset,period){
            var target=$(id);var inst=this._getInst(target[0]);this._adjustInstDate(inst,offset,period);this._updateDatepicker(inst);
        },
        _gotoToday:function(id){
            var target=$(id);var inst=this._getInst(target[0]);if(this._get(inst,'gotoCurrent')&&inst.currentDay){
                inst.selectedDay=inst.currentDay;inst.drawMonth=inst.selectedMonth=inst.currentMonth;inst.drawYear=inst.selectedYear=inst.currentYear;
            }
            else{
                var date=new Date();inst.selectedDay=date.getDate();inst.drawMonth=inst.selectedMonth=date.getMonth();inst.drawYear=inst.selectedYear=date.getFullYear();
            }
            this._notifyChange(inst);this._adjustDate(target);
        },
        _selectMonthYear:function(id,select,period){
            var target=$(id);var inst=this._getInst(target[0]);inst._selectingMonthYear=false;inst['selected'+(period=='M'?'Month':'Year')]=inst['draw'+(period=='M'?'Month':'Year')]=parseInt(select.options[select.selectedIndex].value,10);this._notifyChange(inst);this._adjustDate(target);
        },
        _clickMonthYear:function(id){
            var target=$(id);var inst=this._getInst(target[0]);if(inst.input&&inst._selectingMonthYear&&!$.browser.msie)
                inst.input[0].focus();inst._selectingMonthYear=!inst._selectingMonthYear;
        },
        _changeFirstDay:function(id,day){
            var target=$(id);var inst=this._getInst(target[0]);inst.settings.firstDay=day;this._updateDatepicker(inst);
        },
        _selectDay:function(id,month,year,td){
            if($(td).hasClass(this._unselectableClass))
                return;var target=$(id);var inst=this._getInst(target[0]);var rangeSelect=this._get(inst,'rangeSelect');if(rangeSelect){
                inst.stayOpen=!inst.stayOpen;if(inst.stayOpen){
                    $('.ui-datepicker td',inst.dpDiv).removeClass(this._currentClass);$(td).addClass(this._currentClass);
                }
            }
            inst.selectedDay=inst.currentDay=$('a',td).html();inst.selectedMonth=inst.currentMonth=month;inst.selectedYear=inst.currentYear=year;if(inst.stayOpen){
                inst.endDay=inst.endMonth=inst.endYear=null;
            }
            else if(rangeSelect){
                inst.endDay=inst.currentDay;inst.endMonth=inst.currentMonth;inst.endYear=inst.currentYear;
            }
            this._selectDate(id,this._formatDate(inst,inst.currentDay,inst.currentMonth,inst.currentYear));if(inst.stayOpen){
                inst.rangeStart=new Date(inst.currentYear,inst.currentMonth,inst.currentDay);this._updateDatepicker(inst);
            }
            else if(rangeSelect){
                inst.selectedDay=inst.currentDay=inst.rangeStart.getDate();inst.selectedMonth=inst.currentMonth=inst.rangeStart.getMonth();inst.selectedYear=inst.currentYear=inst.rangeStart.getFullYear();inst.rangeStart=null;if(inst.inline)
                    this._updateDatepicker(inst);
            }
        },
        _clearDate:function(id){
            var target=$(id);var inst=this._getInst(target[0]);if(this._get(inst,'mandatory'))
                return;inst.stayOpen=false;inst.endDay=inst.endMonth=inst.endYear=inst.rangeStart=null;this._selectDate(target,'');
        },
        _selectDate:function(id,dateStr){
            var target=$(id);var inst=this._getInst(target[0]);dateStr=(dateStr!=null?dateStr:this._formatDate(inst));if(this._get(inst,'rangeSelect')&&dateStr)
                dateStr=(inst.rangeStart?this._formatDate(inst,inst.rangeStart):dateStr)+this._get(inst,'rangeSeparator')+dateStr;if(inst.input)
                inst.input.val(dateStr);this._updateAlternate(inst);var onSelect=this._get(inst,'onSelect');if(onSelect)
                onSelect.apply((inst.input?inst.input[0]:null),[dateStr,inst]);else if(inst.input)
                inst.input.trigger('change');if(inst.inline)
                this._updateDatepicker(inst);else if(!inst.stayOpen){
                this._hideDatepicker(null,this._get(inst,'duration'));this._lastInput=inst.input[0];if(typeof(inst.input[0])!='object')
                    inst.input[0].focus();this._lastInput=null;
            }
        },
        _updateAlternate:function(inst){
            var altField=this._get(inst,'altField');if(altField){
                var altFormat=this._get(inst,'altFormat');var date=this._getDate(inst);dateStr=(isArray(date)?(!date[0]&&!date[1]?'':this.formatDate(altFormat,date[0],this._getFormatConfig(inst))+
                    this._get(inst,'rangeSeparator')+this.formatDate(altFormat,date[1]||date[0],this._getFormatConfig(inst))):this.formatDate(altFormat,date,this._getFormatConfig(inst)));$(altField).each(function(){
                    $(this).val(dateStr);
                });
            }
        },
        noWeekends:function(date){
            var day=date.getDay();return[(day>0&&day<6),''];
        },
        iso8601Week:function(date){
            var checkDate=new Date(date.getFullYear(),date.getMonth(),date.getDate(),(date.getTimezoneOffset()/-60));var firstMon=new Date(checkDate.getFullYear(),1-1,4);var firstDay=firstMon.getDay()||7;firstMon.setDate(firstMon.getDate()+1-firstDay);if(firstDay<4&&checkDate<firstMon){
                checkDate.setDate(checkDate.getDate()-3);return $.datepicker.iso8601Week(checkDate);
            }else if(checkDate>new Date(checkDate.getFullYear(),12-1,28)){
                firstDay=new Date(checkDate.getFullYear()+1,1-1,4).getDay()||7;if(firstDay>4&&(checkDate.getDay()||7)<firstDay-3){
                    return 1;
                }
            }
            return Math.floor(((checkDate-firstMon)/86400000)/7)+1;
        },
        dateStatus:function(date,inst){
            return $.datepicker.formatDate($.datepicker._get(inst,'dateStatus'),date,$.datepicker._getFormatConfig(inst));
        },
        parseDate:function(format,value,settings){
            if(format==null||value==null)
                throw'Invalid arguments';value=(typeof value=='object'?value.toString():value+'');if(value=='')
                return null;var shortYearCutoff=(settings?settings.shortYearCutoff:null)||this._defaults.shortYearCutoff;var dayNamesShort=(settings?settings.dayNamesShort:null)||this._defaults.dayNamesShort;var dayNames=(settings?settings.dayNames:null)||this._defaults.dayNames;var monthNamesShort=(settings?settings.monthNamesShort:null)||this._defaults.monthNamesShort;var monthNames=(settings?settings.monthNames:null)||this._defaults.monthNames;var year=-1;var month=-1;var day=-1;var doy=-1;var literal=false;var lookAhead=function(match){
                var matches=(iFormat+1<format.length&&format.charAt(iFormat+1)==match);if(matches)
                    iFormat++;return matches;
            };var getNumber=function(match){
                lookAhead(match);var origSize=(match=='@'?14:(match=='y'?4:(match=='o'?3:2)));var size=origSize;var num=0;while(size>0&&iValue<value.length&&value.charAt(iValue)>='0'&&value.charAt(iValue)<='9'){
                    num=num*10+parseInt(value.charAt(iValue++),10);size--;
                }
                if(size==origSize)
                    throw'Missing number at position '+iValue;return num;
            };var getName=function(match,shortNames,longNames){
                var names=(lookAhead(match)?longNames:shortNames);var size=0;for(var j=0;j<names.length;j++)
                    size=Math.max(size,names[j].length);var name='';var iInit=iValue;while(size>0&&iValue<value.length){
                    name+=value.charAt(iValue++);for(var i=0;i<names.length;i++)
                        if(name==names[i])
                            return i+1;size--;
                }
                throw'Unknown name at position '+iInit;
            };var checkLiteral=function(){
                if(value.charAt(iValue)!=format.charAt(iFormat))
                    throw'Unexpected literal at position '+iValue;iValue++;
            };var iValue=0;for(var iFormat=0;iFormat<format.length;iFormat++){
                if(literal)
                    if(format.charAt(iFormat)=="'"&&!lookAhead("'"))
                        literal=false;else
                        checkLiteral();else
                    switch(format.charAt(iFormat)){
                        case'd':day=getNumber('d');break;case'D':getName('D',dayNamesShort,dayNames);break;case'o':doy=getNumber('o');break;case'm':month=getNumber('m');break;case'M':month=getName('M',monthNamesShort,monthNames);break;case'y':year=getNumber('y');break;case'@':var date=new Date(getNumber('@'));year=date.getFullYear();month=date.getMonth()+1;day=date.getDate();break;case"'":if(lookAhead("'"))
                            checkLiteral();else
                            literal=true;break;default:checkLiteral();
                    }
            }
            if(year<100)
                year+=new Date().getFullYear()-new Date().getFullYear()%100+
                (year<=shortYearCutoff?0:-100);if(doy>-1){
                month=1;day=doy;do{
                    var dim=this._getDaysInMonth(year,month-1);if(day<=dim)
                        break;month++;day-=dim;
                }while(true);
            }
            var date=new Date(year,month-1,day);if(date.getFullYear()!=year||date.getMonth()+1!=month||date.getDate()!=day)
                throw'Invalid date';return date;
        },
        ATOM:'yy-mm-dd',
        COOKIE:'D, dd M yy',
        ISO_8601:'yy-mm-dd',
        RFC_822:'D, d M y',
        RFC_850:'DD, dd-M-y',
        RFC_1036:'D, d M y',
        RFC_1123:'D, d M yy',
        RFC_2822:'D, d M yy',
        RSS:'D, d M y',
        TIMESTAMP:'@',
        W3C:'yy-mm-dd',
        formatDate:function(format,date,settings){
            if(!date)
                return'';var dayNamesShort=(settings?settings.dayNamesShort:null)||this._defaults.dayNamesShort;var dayNames=(settings?settings.dayNames:null)||this._defaults.dayNames;var monthNamesShort=(settings?settings.monthNamesShort:null)||this._defaults.monthNamesShort;var monthNames=(settings?settings.monthNames:null)||this._defaults.monthNames;var lookAhead=function(match){
                var matches=(iFormat+1<format.length&&format.charAt(iFormat+1)==match);if(matches)
                    iFormat++;return matches;
            };var formatNumber=function(match,value,len){
                var num=''+value;if(lookAhead(match))
                    while(num.length<len)
                        num='0'+num;return num;
            };var formatName=function(match,value,shortNames,longNames){
                return(lookAhead(match)?longNames[value]:shortNames[value]);
            };var output='';var literal=false;if(date)
                for(var iFormat=0;iFormat<format.length;iFormat++){
                    if(literal)
                        if(format.charAt(iFormat)=="'"&&!lookAhead("'"))
                            literal=false;else
                            output+=format.charAt(iFormat);else
                        switch(format.charAt(iFormat)){
                            case'd':output+=formatNumber('d',date.getDate(),2);break;case'D':output+=formatName('D',date.getDay(),dayNamesShort,dayNames);break;case'o':var doy=date.getDate();for(var m=date.getMonth()-1;m>=0;m--)
                                doy+=this._getDaysInMonth(date.getFullYear(),m);output+=formatNumber('o',doy,3);break;case'm':output+=formatNumber('m',date.getMonth()+1,2);break;case'M':output+=formatName('M',date.getMonth(),monthNamesShort,monthNames);break;case'y':output+=(lookAhead('y')?date.getFullYear():(date.getYear()%100<10?'0':'')+date.getYear()%100);break;case'@':output+=date.getTime();break;case"'":if(lookAhead("'"))
                                output+="'";else
                                literal=true;break;default:output+=format.charAt(iFormat);
                        }
                }
            return output;
        },
        _possibleChars:function(format){
            var chars='';var literal=false;for(var iFormat=0;iFormat<format.length;iFormat++)
                if(literal)
                    if(format.charAt(iFormat)=="'"&&!lookAhead("'"))
                        literal=false;else
                        chars+=format.charAt(iFormat);else
                    switch(format.charAt(iFormat)){
                        case'd':case'm':case'y':case'@':chars+='0123456789';break;case'D':case'M':return null;case"'":if(lookAhead("'"))
                            chars+="'";else
                            literal=true;break;default:chars+=format.charAt(iFormat);
                    }
            return chars;
        },
        _get:function(inst,name){
            return inst.settings[name]!==undefined?inst.settings[name]:this._defaults[name];
        },
        _setDateFromField:function(inst){
            var dateFormat=this._get(inst,'dateFormat');var dates=inst.input?inst.input.val().split(this._get(inst,'rangeSeparator')):null;inst.endDay=inst.endMonth=inst.endYear=null;var date=defaultDate=this._getDefaultDate(inst);if(dates.length>0){
                var settings=this._getFormatConfig(inst);if(dates.length>1){
                    date=this.parseDate(dateFormat,dates[1],settings)||defaultDate;inst.endDay=date.getDate();inst.endMonth=date.getMonth();inst.endYear=date.getFullYear();
                }
                try{
                    date=this.parseDate(dateFormat,dates[0],settings)||defaultDate;
                }catch(e){
                    this.log(e);date=defaultDate;
                }
            }
            inst.selectedDay=date.getDate();inst.drawMonth=inst.selectedMonth=date.getMonth();inst.drawYear=inst.selectedYear=date.getFullYear();inst.currentDay=(dates[0]?date.getDate():0);inst.currentMonth=(dates[0]?date.getMonth():0);inst.currentYear=(dates[0]?date.getFullYear():0);this._adjustInstDate(inst);
        },
        _getDefaultDate:function(inst){
            var date=this._determineDate(this._get(inst,'defaultDate'),new Date());var minDate=this._getMinMaxDate(inst,'min',true);var maxDate=this._getMinMaxDate(inst,'max');date=(minDate&&date<minDate?minDate:date);date=(maxDate&&date>maxDate?maxDate:date);return date;
        },
        _determineDate:function(date,defaultDate){
            var offsetNumeric=function(offset){
                var date=new Date();date.setUTCDate(date.getUTCDate()+offset);return date;
            };var offsetString=function(offset,getDaysInMonth){
                var date=new Date();var year=date.getFullYear();var month=date.getMonth();var day=date.getDate();var pattern=/([+-]?[0-9]+)\s*(d|D|w|W|m|M|y|Y)?/g;var matches=pattern.exec(offset);while(matches){
                    switch(matches[2]||'d'){
                        case'd':case'D':day+=parseInt(matches[1],10);break;case'w':case'W':day+=parseInt(matches[1],10)*7;break;case'm':case'M':month+=parseInt(matches[1],10);day=Math.min(day,getDaysInMonth(year,month));break;case'y':case'Y':year+=parseInt(matches[1],10);day=Math.min(day,getDaysInMonth(year,month));break;
                    }
                    matches=pattern.exec(offset);
                }
                return new Date(year,month,day);
            };date=(date==null?defaultDate:(typeof date=='string'?offsetString(date,this._getDaysInMonth):(typeof date=='number'?(isNaN(date)?defaultDate:offsetNumeric(date)):date)));return(date&&date.toString()=='Invalid Date'?defaultDate:date);
        },
        _setDate:function(inst,date,endDate){
            var clear=!(date);var origMonth=inst.selectedMonth;var origYear=inst.selectedYear;date=this._determineDate(date,new Date());inst.selectedDay=inst.currentDay=date.getDate();inst.drawMonth=inst.selectedMonth=inst.currentMonth=date.getMonth();inst.drawYear=inst.selectedYear=inst.currentYear=date.getFullYear();if(this._get(inst,'rangeSelect')){
                if(endDate){
                    endDate=this._determineDate(endDate,null);inst.endDay=endDate.getDate();inst.endMonth=endDate.getMonth();inst.endYear=endDate.getFullYear();
                }else{
                    inst.endDay=inst.currentDay;inst.endMonth=inst.currentMonth;inst.endYear=inst.currentYear;
                }
            }
            if(origMonth!=inst.selectedMonth||origYear!=inst.selectedYear)
                this._notifyChange(inst);this._adjustInstDate(inst);if(inst.input)
                inst.input.val(clear?'':this._formatDate(inst)+
                    (!this._get(inst,'rangeSelect')?'':this._get(inst,'rangeSeparator')+
                        this._formatDate(inst,inst.endDay,inst.endMonth,inst.endYear)));
        },
        _getDate:function(inst){
            var startDate=(!inst.currentYear||(inst.input&&inst.input.val()=='')?null:new Date(inst.currentYear,inst.currentMonth,inst.currentDay));if(this._get(inst,'rangeSelect')){
                return[inst.rangeStart||startDate,(!inst.endYear?inst.rangeStart||startDate:new Date(inst.endYear,inst.endMonth,inst.endDay))];
            }else
                return startDate;
        },
        _generateHTML:function(inst){
            var today=new Date();today=new Date(today.getFullYear(),today.getMonth(),today.getDate());var showStatus=this._get(inst,'showStatus');var initStatus=this._get(inst,'initStatus')||'&#xa0;';var isRTL=this._get(inst,'isRTL');var clear=(this._get(inst,'mandatory')?'':'<div class="ui-datepicker-clear"><a onclick="jQuery.datepicker._clearDate(\'#'+inst.id+'\');"'+
                this._addStatus(showStatus,inst.id,this._get(inst,'clearStatus'),initStatus)+'>'+
                this._get(inst,'clearText')+'</a></div>');var controls='<div class="ui-datepicker-control">'+(isRTL?'':clear)+'<div class="ui-datepicker-close"><a onclick="jQuery.datepicker._hideDatepicker();"'+
            this._addStatus(showStatus,inst.id,this._get(inst,'closeStatus'),initStatus)+'>'+
            this._get(inst,'closeText')+'</a></div>'+(isRTL?clear:'')+'</div>';var prompt=this._get(inst,'prompt');var closeAtTop=this._get(inst,'closeAtTop');var hideIfNoPrevNext=this._get(inst,'hideIfNoPrevNext');var navigationAsDateFormat=this._get(inst,'navigationAsDateFormat');var showBigPrevNext=this._get(inst,'showBigPrevNext');var numMonths=this._getNumberOfMonths(inst);var showCurrentAtPos=this._get(inst,'showCurrentAtPos');var stepMonths=this._get(inst,'stepMonths');var stepBigMonths=this._get(inst,'stepBigMonths');var isMultiMonth=(numMonths[0]!=1||numMonths[1]!=1);var currentDate=(!inst.currentDay?new Date(9999,9,9):new Date(inst.currentYear,inst.currentMonth,inst.currentDay));var minDate=this._getMinMaxDate(inst,'min',true);var maxDate=this._getMinMaxDate(inst,'max');var drawMonth=inst.drawMonth-showCurrentAtPos;var drawYear=inst.drawYear;if(drawMonth<0){
                drawMonth+=12;drawYear--;
            }
            if(maxDate){
                var maxDraw=new Date(maxDate.getFullYear(),maxDate.getMonth()-numMonths[1]+1,maxDate.getDate());maxDraw=(minDate&&maxDraw<minDate?minDate:maxDraw);while(new Date(drawYear,drawMonth,1)>maxDraw){
                    drawMonth--;if(drawMonth<0){
                        drawMonth=11;drawYear--;
                    }
                }
            }
            var prevText=this._get(inst,'prevText');prevText=(!navigationAsDateFormat?prevText:this.formatDate(prevText,new Date(drawYear,drawMonth-stepMonths,1),this._getFormatConfig(inst)));var prevBigText=(showBigPrevNext?this._get(inst,'prevBigText'):'');prevBigText=(!navigationAsDateFormat?prevBigText:this.formatDate(prevBigText,new Date(drawYear,drawMonth-stepBigMonths,1),this._getFormatConfig(inst)));var prev='<div class="ui-datepicker-prev">'+(this._canAdjustMonth(inst,-1,drawYear,drawMonth)?(showBigPrevNext?'<a onclick="jQuery.datepicker._adjustDate(\'#'+inst.id+'\', -'+stepBigMonths+', \'M\');"'+
                this._addStatus(showStatus,inst.id,this._get(inst,'prevBigStatus'),initStatus)+'>'+prevBigText+'</a>':'')+'<a onclick="jQuery.datepicker._adjustDate(\'#'+inst.id+'\', -'+stepMonths+', \'M\');"'+
            this._addStatus(showStatus,inst.id,this._get(inst,'prevStatus'),initStatus)+'>'+prevText+'</a>':(hideIfNoPrevNext?'':'<label>'+prevBigText+'</label><label>'+prevText+'</label>'))+'</div>';var nextText=this._get(inst,'nextText');nextText=(!navigationAsDateFormat?nextText:this.formatDate(nextText,new Date(drawYear,drawMonth+stepMonths,1),this._getFormatConfig(inst)));var nextBigText=(showBigPrevNext?this._get(inst,'nextBigText'):'');nextBigText=(!navigationAsDateFormat?nextBigText:this.formatDate(nextBigText,new Date(drawYear,drawMonth+stepBigMonths,1),this._getFormatConfig(inst)));var next='<div class="ui-datepicker-next">'+(this._canAdjustMonth(inst,+1,drawYear,drawMonth)?'<a onclick="jQuery.datepicker._adjustDate(\'#'+inst.id+'\', +'+stepMonths+', \'M\');"'+
                this._addStatus(showStatus,inst.id,this._get(inst,'nextStatus'),initStatus)+'>'+nextText+'</a>'+
                (showBigPrevNext?'<a onclick="jQuery.datepicker._adjustDate(\'#'+inst.id+'\', +'+stepBigMonths+', \'M\');"'+
                    this._addStatus(showStatus,inst.id,this._get(inst,'nextBigStatus'),initStatus)+'>'+nextBigText+'</a>':''):(hideIfNoPrevNext?'':'<label>'+nextText+'</label><label>'+nextBigText+'</label>'))+'</div>';var currentText=this._get(inst,'currentText');var gotoDate=(this._get(inst,'gotoCurrent')&&inst.currentDay?currentDate:today);currentText=(!navigationAsDateFormat?currentText:this.formatDate(currentText,gotoDate,this._getFormatConfig(inst)));var html=(prompt?'<div class="'+this._promptClass+'">'+prompt+'</div>':'')+
            (closeAtTop&&!inst.inline?controls:'')+'<div class="ui-datepicker-links">'+(isRTL?next:prev)+
            (this._isInRange(inst,gotoDate)?'<div class="ui-datepicker-current">'+'<a onclick="jQuery.datepicker._gotoToday(\'#'+inst.id+'\');"'+
                this._addStatus(showStatus,inst.id,this._get(inst,'currentStatus'),initStatus)+'>'+
                currentText+'</a></div>':'')+(isRTL?prev:next)+'</div>';var firstDay=this._get(inst,'firstDay');var changeFirstDay=this._get(inst,'changeFirstDay');var dayNames=this._get(inst,'dayNames');var dayNamesShort=this._get(inst,'dayNamesShort');var dayNamesMin=this._get(inst,'dayNamesMin');var monthNames=this._get(inst,'monthNames');var beforeShowDay=this._get(inst,'beforeShowDay');var highlightWeek=this._get(inst,'highlightWeek');var showOtherMonths=this._get(inst,'showOtherMonths');var showWeeks=this._get(inst,'showWeeks');var calculateWeek=this._get(inst,'calculateWeek')||this.iso8601Week;var weekStatus=this._get(inst,'weekStatus');var status=(showStatus?this._get(inst,'dayStatus')||initStatus:'');var dateStatus=this._get(inst,'statusForDate')||this.dateStatus;var endDate=inst.endDay?new Date(inst.endYear,inst.endMonth,inst.endDay):currentDate;for(var row=0;row<numMonths[0];row++)
                for(var col=0;col<numMonths[1];col++){
                    var selectedDate=new Date(drawYear,drawMonth,inst.selectedDay);html+='<div class="ui-datepicker-one-month'+(col==0?' ui-datepicker-new-row':'')+'">'+
                    this._generateMonthYearHeader(inst,drawMonth,drawYear,minDate,maxDate,selectedDate,row>0||col>0,showStatus,initStatus,monthNames)+'<table class="ui-datepicker" cellpadding="0" cellspacing="0"><thead>'+'<tr class="ui-datepicker-title-row">'+
                    (showWeeks?'<td'+this._addStatus(showStatus,inst.id,weekStatus,initStatus)+'>'+
                        this._get(inst,'weekHeader')+'</td>':'');for(var dow=0;dow<7;dow++){
                        var day=(dow+firstDay)%7;var dayStatus=(status.indexOf('DD')>-1?status.replace(/DD/,dayNames[day]):status.replace(/D/,dayNamesShort[day]));html+='<td'+((dow+firstDay+6)%7>=5?' class="ui-datepicker-week-end-cell"':'')+'>'+
                        (!changeFirstDay?'<span':'<a onclick="jQuery.datepicker._changeFirstDay(\'#'+inst.id+'\', '+day+');"')+
                        this._addStatus(showStatus,inst.id,dayStatus,initStatus)+' title="'+dayNames[day]+'">'+
                        dayNamesMin[day]+(changeFirstDay?'</a>':'</span>')+'</td>';
                    }
                    html+='</tr></thead><tbody>';var daysInMonth=this._getDaysInMonth(drawYear,drawMonth);if(drawYear==inst.selectedYear&&drawMonth==inst.selectedMonth)
                        inst.selectedDay=Math.min(inst.selectedDay,daysInMonth);var leadDays=(this._getFirstDayOfMonth(drawYear,drawMonth)-firstDay+7)%7;var tzDate=new Date(drawYear,drawMonth,1-leadDays);var utcDate=new Date(drawYear,drawMonth,1-leadDays);var printDate=utcDate;var numRows=(isMultiMonth?6:Math.ceil((leadDays+daysInMonth)/7));for(var dRow=0;dRow<numRows;dRow++){
                        html+='<tr class="ui-datepicker-days-row">'+
                        (showWeeks?'<td class="ui-datepicker-week-col"'+
                            this._addStatus(showStatus,inst.id,weekStatus,initStatus)+'>'+
                            calculateWeek(printDate)+'</td>':'');for(var dow=0;dow<7;dow++){
                            var daySettings=(beforeShowDay?beforeShowDay.apply((inst.input?inst.input[0]:null),[printDate]):[true,'']);var otherMonth=(printDate.getMonth()!=drawMonth);var unselectable=otherMonth||!daySettings[0]||(minDate&&printDate<minDate)||(maxDate&&printDate>maxDate);html+='<td class="ui-datepicker-days-cell'+
                            ((dow+firstDay+6)%7>=5?' ui-datepicker-week-end-cell':'')+

                            (otherMonth?' ui-datepicker-other-month':'')+
                            (printDate.getTime()==selectedDate.getTime()&&drawMonth==inst.selectedMonth?' ui-datepicker-days-cell-over':'')+
                            (unselectable?' '+this._unselectableClass:'')+
                            (otherMonth&&!showOtherMonths?'':' '+daySettings[1]+
                                (printDate.getTime()>=currentDate.getTime()&&printDate.getTime()<=endDate.getTime()?' '+this._currentClass:'')+
                                (printDate.getTime()==today.getTime()?' ui-datepicker-today':''))+'"'+
                            ((!otherMonth||showOtherMonths)&&daySettings[2]?' title="'+daySettings[2]+'"':'')+
                            (unselectable?(highlightWeek?' onmouseover="jQuery(this).parent().addClass(\'ui-datepicker-week-over\');"'+' onmouseout="jQuery(this).parent().removeClass(\'ui-datepicker-week-over\');"':''):' onmouseover="jQuery(this).addClass(\'ui-datepicker-days-cell-over\')'+
                                (highlightWeek?'.parent().addClass(\'ui-datepicker-week-over\')':'')+';'+
                                (!showStatus||(otherMonth&&!showOtherMonths)?'':'jQuery(\'#ui-datepicker-status-'+
                                    inst.id+'\').html(\''+(dateStatus.apply((inst.input?inst.input[0]:null),[printDate,inst])||initStatus)+'\');')+'"'+' onmouseout="jQuery(this).removeClass(\'ui-datepicker-days-cell-over\')'+
                                (highlightWeek?'.parent().removeClass(\'ui-datepicker-week-over\')':'')+';'+
                                (!showStatus||(otherMonth&&!showOtherMonths)?'':'jQuery(\'#ui-datepicker-status-'+
                                    inst.id+'\').html(\''+initStatus+'\');')+'" onclick="jQuery.datepicker._selectDay(\'#'+
                                inst.id+'\','+drawMonth+','+drawYear+', this);"')+'>'+
                            (otherMonth?(showOtherMonths?printDate.getDate():'&#xa0;'):(unselectable?printDate.getDate():'<a>'+printDate.getDate()+'</a>'))+'</td>';tzDate.setDate(tzDate.getDate()+1);utcDate.setUTCDate(utcDate.getUTCDate()+1);printDate=(tzDate>utcDate?tzDate:utcDate);
                        }
                        html+='</tr>';
                    }
                    drawMonth++;if(drawMonth>11){
                        drawMonth=0;drawYear++;
                    }
                    html+='</tbody></table></div>';
                }
            html+=(showStatus?'<div style="clear: both;"></div><div id="ui-datepicker-status-'+inst.id+'" class="ui-datepicker-status">'+initStatus+'</div>':'')+
            (!closeAtTop&&!inst.inline?controls:'')+'<div style="clear: both;"></div>'+
            ($.browser.msie&&parseInt($.browser.version,10)<7&&!inst.inline?'<iframe src="javascript:false;" class="ui-datepicker-cover"></iframe>':'');return html;
        },
        _generateMonthYearHeader:function(inst,drawMonth,drawYear,minDate,maxDate,selectedDate,secondary,showStatus,initStatus,monthNames){
            minDate=(inst.rangeStart&&minDate&&selectedDate<minDate?selectedDate:minDate);var showMonthAfterYear=this._get(inst,'showMonthAfterYear');var html='<div class="ui-datepicker-header">';var monthHtml='';if(secondary||!this._get(inst,'changeMonth'))
                monthHtml+=monthNames[drawMonth]+'&#xa0;';else{
                var inMinYear=(minDate&&minDate.getFullYear()==drawYear);var inMaxYear=(maxDate&&maxDate.getFullYear()==drawYear);monthHtml+='<select class="ui-datepicker-new-month" '+'onchange="jQuery.datepicker._selectMonthYear(\'#'+inst.id+'\', this, \'M\');" '+'onclick="jQuery.datepicker._clickMonthYear(\'#'+inst.id+'\');"'+
                this._addStatus(showStatus,inst.id,this._get(inst,'monthStatus'),initStatus)+'>';for(var month=0;month<12;month++){
                    if((!inMinYear||month>=minDate.getMonth())&&(!inMaxYear||month<=maxDate.getMonth()))
                        monthHtml+='<option value="'+month+'"'+
                        (month==drawMonth?' selected="selected"':'')+'>'+monthNames[month]+'</option>';
                }
                monthHtml+='</select>';
            }
            if(!showMonthAfterYear)
                html+=monthHtml;if(secondary||!this._get(inst,'changeYear'))
                html+=drawYear;else{
                var years=this._get(inst,'yearRange').split(':');var year=0;var endYear=0;if(years.length!=2){
                    year=drawYear-10;endYear=drawYear+10;
                }else if(years[0].charAt(0)=='+'||years[0].charAt(0)=='-'){
                    year=endYear=new Date().getFullYear();year+=parseInt(years[0],30);endYear+=parseInt(years[1],30);
                }else{
                    year=parseInt(years[0],10);endYear=parseInt(years[1],10);
                }
                year=(minDate?Math.max(year,minDate.getFullYear()):year);endYear=(maxDate?Math.min(endYear,maxDate.getFullYear()):endYear);html+='<select class="ui-datepicker-new-year" '+'onchange="jQuery.datepicker._selectMonthYear(\'#'+inst.id+'\', this, \'Y\');" '+'onclick="jQuery.datepicker._clickMonthYear(\'#'+inst.id+'\');"'+
                this._addStatus(showStatus,inst.id,this._get(inst,'yearStatus'),initStatus)+'>';for(;year<=endYear;year++){
                    html+='<option value="'+year+'"'+
                    (year==drawYear?' selected="selected"':'')+'>'+year+'</option>';
                }
                html+='</select>';
            }
            if(showMonthAfterYear)
                html+=monthHtml;html+='</div>';return html;
        },
        _addStatus:function(showStatus,id,text,initStatus){
            return(showStatus?' onmouseover="jQuery(\'#ui-datepicker-status-'+id+'\').html(\''+(text||initStatus)+'\');" '+'onmouseout="jQuery(\'#ui-datepicker-status-'+id+'\').html(\''+initStatus+'\');"':'');
        },
        _adjustInstDate:function(inst,offset,period){
            var year=inst.drawYear+(period=='Y'?offset:0);var month=inst.drawMonth+(period=='M'?offset:0);var day=Math.min(inst.selectedDay,this._getDaysInMonth(year,month))+
            (period=='D'?offset:0);var date=new Date(year,month,day);var minDate=this._getMinMaxDate(inst,'min',true);var maxDate=this._getMinMaxDate(inst,'max');date=(minDate&&date<minDate?minDate:date);date=(maxDate&&date>maxDate?maxDate:date);inst.selectedDay=date.getDate();inst.drawMonth=inst.selectedMonth=date.getMonth();inst.drawYear=inst.selectedYear=date.getFullYear();if(period=='M'||period=='Y')
                this._notifyChange(inst);
        },
        _notifyChange:function(inst){
            var onChange=this._get(inst,'onChangeMonthYear');if(onChange)
                onChange.apply((inst.input?inst.input[0]:null),[inst.selectedYear,inst.selectedMonth+1,inst]);
        },
        _getNumberOfMonths:function(inst){
            var numMonths=this._get(inst,'numberOfMonths');return(numMonths==null?[1,1]:(typeof numMonths=='number'?[1,numMonths]:numMonths));
        },
        _getMinMaxDate:function(inst,minMax,checkRange){
            var date=this._determineDate(this._get(inst,minMax+'Date'),null);if(date){
                date.setHours(0);date.setMinutes(0);date.setSeconds(0);date.setMilliseconds(0);
            }
            return(!checkRange||!inst.rangeStart?date:(!date||inst.rangeStart>date?inst.rangeStart:date));
        },
        _getDaysInMonth:function(year,month){
            return 32-new Date(year,month,32).getDate();
        },
        _getFirstDayOfMonth:function(year,month){
            return new Date(year,month,1).getDay();
        },
        _canAdjustMonth:function(inst,offset,curYear,curMonth){
            var numMonths=this._getNumberOfMonths(inst);var date=new Date(curYear,curMonth+(offset<0?offset:numMonths[1]),1);if(offset<0)
                date.setDate(this._getDaysInMonth(date.getFullYear(),date.getMonth()));return this._isInRange(inst,date);
        },
        _isInRange:function(inst,date){
            var newMinDate=(!inst.rangeStart?null:new Date(inst.selectedYear,inst.selectedMonth,inst.selectedDay));newMinDate=(newMinDate&&inst.rangeStart<newMinDate?inst.rangeStart:newMinDate);var minDate=newMinDate||this._getMinMaxDate(inst,'min');var maxDate=this._getMinMaxDate(inst,'max');return((!minDate||date>=minDate)&&(!maxDate||date<=maxDate));
        },
        _getFormatConfig:function(inst){
            var shortYearCutoff=this._get(inst,'shortYearCutoff');shortYearCutoff=(typeof shortYearCutoff!='string'?shortYearCutoff:new Date().getFullYear()%100+parseInt(shortYearCutoff,10));return{
                shortYearCutoff:shortYearCutoff,
                dayNamesShort:this._get(inst,'dayNamesShort'),
                dayNames:this._get(inst,'dayNames'),
                monthNamesShort:this._get(inst,'monthNamesShort'),
                monthNames:this._get(inst,'monthNames')
            };
        },
        _formatDate:function(inst,day,month,year){
            if(!day){
                inst.currentDay=inst.selectedDay;inst.currentMonth=inst.selectedMonth;inst.currentYear=inst.selectedYear;
            }
            var date=(day?(typeof day=='object'?day:new Date(year,month,day)):new Date(inst.currentYear,inst.currentMonth,inst.currentDay));return this.formatDate(this._get(inst,'dateFormat'),date,this._getFormatConfig(inst));
        }
    });function extendRemove(target,props){
        $.extend(target,props);for(var name in props)
            if(props[name]==null||props[name]==undefined)
                target[name]=props[name];return target;
    };function isArray(a){
        return(a&&(($.browser.safari&&typeof a=='object'&&a.length)||(a.constructor&&a.constructor.toString().match(/\Array\(\)/))));
    };$.fn.datepicker=function(options){
        if(!$.datepicker.initialized){
            $(document.body).append($.datepicker.dpDiv).mousedown($.datepicker._checkExternalClick);$.datepicker.initialized=true;
        }
        var otherArgs=Array.prototype.slice.call(arguments,1);if(typeof options=='string'&&(options=='isDisabled'||options=='getDate'))
            return $.datepicker['_'+options+'Datepicker'].apply($.datepicker,[this[0]].concat(otherArgs));return this.each(function(){
            typeof options=='string'?$.datepicker['_'+options+'Datepicker'].apply($.datepicker,[this].concat(otherArgs)):$.datepicker._attachDatepicker(this,options);
        });
    };$.datepicker=new Datepicker();$.datepicker.initialized=false;$.datepicker.uuid=new Date().getTime();
})(jQuery);(function($){
    var counter=0;$.widget("ui.magnifier",{
        _init:function(){
            var self=this,o=this.options;this.element.addClass("ui-magnifier").bind('click.magnifier',function(e){
                (!self.disabled&&o.click&&o.click.apply(this,[e,{
                    options:self.options,
                    current:self.current[0],
                    currentOffset:self.current[1]
                }]));
            });if(!(/^(r|a)/).test(this.element.css("position"))){
                this.element.css("position","relative");
            }
            this.items=[];this.element.find(o.items).each(function(){
                var $this=$(this);self.items.push([this,$this.offset(),[$this.width(),$this.height()],(o.overlap?$this.position():null)]);(o.opacity&&$this.css('opacity',o.opacity.min));
            });(o.overlap&&$.each(this.items,function(){
                $(this[0]).css({
                    position:"absolute",
                    top:this[3].top,
                    left:this[3].left
                });
            }));this.identifier=++counter;$(document).bind("mousemove.magnifier"+this.identifier,function(e){
                (self.disabled||self._magnify.apply(self,[e]));
            });this.pp=this.element.offset();
        },
        destroy:function(){
            this.reset();this.element.removeClass("ui-magnifier ui-magnifier-disabled").unbind(".magnifier");$(document).unbind("mousemove.magnifier"+this.identifier);
        },
        disable:function(){
            this.reset();$.widget.prototype.disable.apply(this,arguments);
        },
        reset:function(e){
            var o=this.options;$.each(this.items,function(){
                var item=this;$(item[0]).css({
                    width:item[2][0],
                    height:item[2][1],
                    top:(item[3]?item[3].top:0),
                    left:(item[3]?item[3].left:0)
                });(o.opacity&&$(item[0]).css('opacity',o.opacity.min));(o.zIndex&&$(item[0]).css("z-index",""));
            });
        },
        _magnify:function(e){
            var p=[e.pageX,e.pageY],o=this.options,c,distance=1;this.current=this.items[0];var overlap=((p[0]>this.pp.left-o.distance)&&(p[0]<this.pp.left+this.element[0].offsetWidth+o.distance)&&(p[1]>this.pp.top-o.distance)&&(p[1]<this.pp.top+this.element[0].offsetHeight+o.distance));if(!overlap){
                return false;
            }
            for(var i=0;i<this.items.length;i++){
                c=this.items[i];var olddistance=distance;if(!o.axis){
                    distance=Math.sqrt(Math.pow(p[0]-((c[3]?this.pp.left:c[1].left)+parseInt(c[0].style.left,10))-(c[0].offsetWidth/2),2)
                        +Math.pow(p[1]-((c[3]?this.pp.top:c[1].top)+parseInt(c[0].style.top,10))-(c[0].offsetHeight/2),2));
                }else{
                    if(o.axis=="y"){
                        distance=Math.abs(p[1]-((c[3]?this.pp.top:c[1].top)+parseInt(c[0].style.top,10))-(c[0].offsetHeight/2));
                    }else{
                        distance=Math.abs(p[0]-((c[3]?this.pp.left:c[1].left)+parseInt(c[0].style.left,10))-(c[0].offsetWidth/2));
                    }
                }
                if(distance<o.distance){
                    this.current=distance<olddistance?c:this.current;if(!o.axis||o.axis!="y"){
                        $(c[0]).css({
                            width:c[2][0]+(c[2][0]*(o.magnification-1))-(((distance/o.distance)*c[2][0])*(o.magnification-1)),
                            left:(c[3]?(c[3].left+o.verticalLine*((c[2][1]*(o.magnification-1))-(((distance/o.distance)*c[2][1])*(o.magnification-1)))):0)
                        });
                    }
                    if(!o.axis||o.axis!="x"){
                        $(c[0]).css({
                            height:c[2][1]+(c[2][1]*(o.magnification-1))-(((distance/o.distance)*c[2][1])*(o.magnification-1)),
                            top:(c[3]?c[3].top:0)+(o.baseline-0.5)*((c[2][0]*(o.magnification-1))-(((distance/o.distance)*c[2][0])*(o.magnification-1)))
                        });
                    }
                    if(o.opacity){
                        $(c[0]).css('opacity',o.opacity.max-(distance/o.distance)<o.opacity.min?o.opacity.min:o.opacity.max-(distance/o.distance));
                    }
                }else{
                    $(c[0]).css({
                        width:c[2][0],
                        height:c[2][1],
                        top:(c[3]?c[3].top:0),
                        left:(c[3]?c[3].left:0)
                    });(o.opacity&&$(c[0]).css('opacity',o.opacity.min));
                }
                (o.zIndex&&$(c[0]).css("z-index",""));
            }
            (o.zIndex&&$(this.current[0]).css("z-index",o.zIndex));
        }
    });$.extend($.ui.magnifier,{
        defaults:{
            distance:150,
            magnification:2,
            baseline:0,
            verticalLine:-0.5,
            items:"> *"
        }
    });
})(jQuery);(function($){
    $.widget("ui.progressbar",{
        _init:function(){
            this._interval=this.options.interval;var self=this,options=this.options,id=(new Date()).getTime()+Math.random(),text=options.text||'0%';this.element.addClass("ui-progressbar").width(options.width);$.extend(this,{
                active:false,
                pixelState:0,
                percentState:0,
                identifier:id,
                bar:$('<div class="ui-progressbar-bar ui-hidden"></div>').css({
                    width:'0px',
                    overflow:'hidden',
                    zIndex:100
                }),
                textElement:$('<div class="ui-progressbar-text"></div>').html(text).css({
                    width:'0px',
                    overflow:'hidden'
                }),
                textBg:$('<div class="ui-progressbar-text ui-progressbar-text-back"></div>').html(text).css({
                    width:this.element.width()
                }),
                wrapper:$('<div class="ui-progressbar-wrap"></div>')
            });this.wrapper.append(this.bar.append(this.textElement.addClass(options.textClass)),this.textBg).appendTo(this.element);
        },
        plugins:{},
        ui:function(e){
            return{
                instance:this,
                identifier:this.identifier,
                options:this.options,
                element:this.bar,
                textElement:this.textElement,
                pixelState:this.pixelState,
                percentState:this.percentState
            };
        },
        _propagate:function(n,e){
            $.ui.plugin.call(this,n,[e,this.ui()]);this.element.triggerHandler(n=="progressbar"?n:["progressbar",n].join(""),[e,this.ui()],this.options[n]);
        },
        destroy:function(){
            this.stop();this.element.removeClass("ui-progressbar ui-progressbar-disabled").removeData("progressbar").unbind(".progressbar").find('.ui-progressbar-wrap').remove();delete jQuery.easing[this.identifier];
        },
        enable:function(){
            this.element.removeClass("ui-progressbar-disabled");this.disabled=false;
        },
        disable:function(){
            this.element.addClass("ui-progressbar-disabled");this.disabled=true;
        },
        start:function(){
            var self=this,options=this.options;if(this.disabled){
                return;
            }
            jQuery.easing[this.identifier]=function(x,t,b,c,d){
                var inc=options.increment,width=options.width,step=((inc>width?width:inc)/width),state=Math.round(x/step)*step;return state>1?1:state;
            };self.active=true;setTimeout(function(){
                self.active=false;
            },options.duration);this._animate();this._propagate('start',this.ui());return false;
        },
        _animate:function(){
            var self=this,options=this.options,interval=options.interval;this.bar.animate({
                width:options.width
            },{
                duration:interval,
                easing:this.identifier,
                step:function(step,b){
                    self.progress((step/options.width)*100);var timestamp=new Date().getTime(),elapsedTime=(timestamp-b.startTime);options.interval=interval-elapsedTime;
                },
                complete:function(){
                    delete jQuery.easing[self.identifier];self.pause();if(self.active){}
                }
            });
        },
        pause:function(){
            if(this.disabled)return;this.bar.stop();this._propagate('pause',this.ui());
        },
        stop:function(){
            this.bar.stop();this.bar.width(0);this.textElement.width(0);this.bar.addClass('ui-hidden');this.options.interval=this._interval;this._propagate('stop',this.ui());
        },
        text:function(text){
            this.textElement.html(text);this.textBg.html(text);
        },
        progress:function(percentState){
            if(this.bar.is('.ui-hidden')){
                this.bar.removeClass('ui-hidden');
            }
            this.percentState=percentState>100?100:percentState;this.pixelState=(this.percentState/100)*this.options.width;this.bar.width(this.pixelState);this.textElement.width(this.pixelState);if(this.options.range&&!this.options.text){
                this.textElement.html(Math.round(this.percentState)+'%');
            }
            this._propagate('progress',this.ui());
        }
    });$.ui.progressbar.defaults={
        width:300,
        duration:3000,
        interval:200,
        increment:1,
        range:true,
        text:'',
        addClass:'',
        textClass:''
    };
})(jQuery);(function($){
    $.widget('ui.spinner',{
        _init:function(){
            if($.data(this.element[0],'spinner'))return;if(this.options.init){
                this.options.init(this.ui(null));
            }
            this._decimals=0;if(this.options.stepping.toString().indexOf('.')!=-1){
                var s=this.options.stepping.toString();this._decimals=s.slice(s.indexOf('.')+1,s.length).length;
            }
            var self=this;this.element.addClass('ui-spinner-box').attr('autocomplete','off');this._setValue(isNaN(this._getValue())?this.options.start:this._getValue());this.element.wrap('<div>').parent().addClass('ui-spinner').append('<button class="ui-spinner-up" type="button">&#9650;</button>').find('.ui-spinner-up').bind('mousedown',function(e){
                $(this).addClass('ui-spinner-pressed');if(!self.counter)self.counter=1;self._mousedown(100,'_up',e);
            }).bind('mouseup',function(e){
                $(this).removeClass('ui-spinner-pressed');if(self.counter==1)self._up(e);self._mouseup(e);
            }).bind('mouseout',function(e){
                $(this).removeClass('ui-spinner-pressed');self._mouseup(e);
            }).bind('dblclick',function(e){
                $(this).removeClass('ui-spinner-pressed');self._up(e);
            }).bind('keydown.spinner',function(e){
                var KEYS=$.keyCode;if(e.keyCode==KEYS.SPACE||e.keyCode==KEYS.ENTER){
                    $(this).addClass('ui-spinner-pressed');if(!self.counter)self.counter=1;self._up.call(self,e);
                }else if(e.keyCode==KEYS.DOWN||e.keyCode==KEYS.RIGHT){
                    self.element.siblings('.ui-spinner-down').focus();
                }else if(e.keyCode==KEYS.LEFT){
                    self.element.focus();
                }
            }).bind('keyup.spinner',function(e){
                $(this).removeClass('ui-spinner-pressed');self.counter=0;self._propagate('change',e);
            }).end().append('<button class="ui-spinner-down" type="button">&#9660;</button>').find('.ui-spinner-down').bind('mousedown',function(e){
                $(this).addClass('ui-spinner-pressed');if(!self.counter)self.counter=1;self._mousedown(100,'_down',e);
            }).bind('mouseup',function(e){
                $(this).removeClass('ui-spinner-pressed');if(self.counter==1)self._down();self._mouseup(e);
            }).bind('mouseout',function(e){
                $(this).removeClass('ui-spinner-pressed');self._mouseup(e);
            }).bind('dblclick',function(e){
                $(this).removeClass('ui-spinner-pressed');self._down(e);
            }).bind('keydown.spinner',function(e){
                var KEYS=$.keyCode;if(e.keyCode==KEYS.SPACE||e.keyCode==KEYS.ENTER){
                    $(this).addClass('ui-spinner-pressed');if(!self.counter)self.counter=1;self._down.call(self,e);
                }else if(e.keyCode==KEYS.UP||e.keyCode==KEYS.LEFT){
                    self.element.siblings('.ui-spinner-up').focus();
                }
            }).bind('keyup.spinner',function(e){
                $(this).removeClass('ui-spinner-pressed');self.counter=0;self._propagate('change',e);
            }).end();this._items=this.element.children().length;if(this._items>1){
                this.element.addClass('ui-spinner-list').css('height',this.element.outerHeight()/this._items).children().addClass('ui-spinner-listitem').end().parent().css('height',this.element.outerHeight()).end();this.options.stepping=1;this.options.min=0;this.options.max=this._items-1;
            }
            this.element.bind('keydown.spinner',function(e){
                if(!self.counter)self.counter=1;return self._keydown.call(self,e);
            }).bind('keyup.spinner',function(e){
                self.counter=0;self._propagate('change',e);
            }).bind('blur.spinner',function(e){
                self._cleanUp();
            });if($.fn.mousewheel){
                this.element.mousewheel(function(e,delta){
                    self._mousewheel(e,delta);
                });
            }
        },
        _constrain:function(){
            if(this.options.min!=undefined&&this._getValue()<this.options.min)this._setValue(this.options.min);if(this.options.max!=undefined&&this._getValue()>this.options.max)this._setValue(this.options.max);
        },
        _cleanUp:function(){
            this._setValue(this._getValue());this._constrain();
        },
        _spin:function(d,e){
            if(this.disabled)return;if(isNaN(this._getValue()))this._setValue(this.options.start);this._setValue(this._getValue()+(d=='up'?1:-1)*(this.options.incremental&&this.counter>100?(this.counter>200?100:10):1)*this.options.stepping);this._animate(d);this._constrain();if(this.counter)this.counter++;this._propagate('spin',e);
        },
        _down:function(e){
            this._spin('down',e);this._propagate('down',e);
        },
        _up:function(e){
            this._spin('up',e);this._propagate('up',e);
        },
        _mousedown:function(i,d,e){
            var self=this;i=i||100;if(this.timer)window.clearInterval(this.timer);this.timer=window.setInterval(function(){
                self[d](e);if(self.counter>20)self._mousedown(20,d,e);
            },i);
        },
        _mouseup:function(e){
            this.counter=0;if(this.timer)window.clearInterval(this.timer);this.element[0].focus();this._propagate('change',e);
        },
        _keydown:function(e){
            var KEYS=$.keyCode;if(e.keyCode==KEYS.UP)this._up(e);if(e.keyCode==KEYS.DOWN)this._down(e);if(e.keyCode==KEYS.HOME)this._setValue(this.options.min||this.options.start);if(e.keyCode==KEYS.END&&this.options.max!=undefined)this._setValue(this.options.max);return(e.keyCode==KEYS.TAB||e.keyCode==KEYS.BACKSPACE||e.keyCode==KEYS.LEFT||e.keyCode==KEYS.RIGHT||e.keyCode==KEYS.PERIOD||e.keyCode==KEYS.NUMPAD_DECIMAL||e.keyCode==KEYS.NUMPAD_SUBTRACT||(e.keyCode>=96&&e.keyCode<=105)||(/[0-9\-\.]/).test(String.fromCharCode(e.keyCode)))?true:false;
        },
        _mousewheel:function(e,delta){
            delta=($.browser.opera?-delta/Math.abs(delta):delta);delta>0?this._up(e):this._down(e);e.preventDefault();
        },
        _getValue:function(){
            return parseFloat(this.element.val().replace(/[^0-9\-\.]/g,''));
        },
        _setValue:function(newVal){
            if(isNaN(newVal))newVal=this.options.start;this.element.val(this.options.currency?$.ui.spinner.format.currency(newVal,this.options.currency):$.ui.spinner.format.number(newVal,this._decimals));
        },
        _animate:function(d){
            if(this.element.hasClass('ui-spinner-list')&&((d=='up'&&this._getValue()<=this.options.max)||(d=='down'&&this._getValue()>=this.options.min))){
                this.element.animate({
                    marginTop:'-'+this._getValue()*this.element.outerHeight()
                },{
                    duration:'fast',
                    queue:false
                });
            }
        },
        _addItem:function(html){
            if(!this.element.is('input')){
                var wrapper='div';if(this.element.is('ol')||this.element.is('ul')){
                    wrapper='li';
                }
                this.element.append('<'+wrapper+' class="ui-spinner-dyn">'+html+'</'+wrapper+'>');
            }
        },
        plugins:{},
        ui:function(e){
            return{
                options:this.options,
                element:this.element,
                value:this._getValue(),
                add:this._addItem
            };
        },
        _propagate:function(n,e){
            $.ui.plugin.call(this,n,[e,this.ui()]);return this.element.triggerHandler(n=='spin'?n:'spin'+n,[e,this.ui()],this.options[n]);
        },
        destroy:function(){
            if(!$.data(this.element[0],'spinner'))return;if($.fn.mousewheel){
                this.element.unmousewheel();
            }
            this.element.removeClass('ui-spinner-box ui-spinner-list').removeAttr('disabled').removeAttr('autocomplete').removeData('spinner').unbind('.spinner').siblings().remove().end().children().removeClass('ui-spinner-listitem').remove('.ui-spinner-dyn').end().parent().removeClass('ui-spinner ui-spinner-disabled').before(this.element.clone()).remove().end();
        },
        enable:function(){
            this.element.removeAttr('disabled').siblings().removeAttr('disabled').parent().removeClass('ui-spinner-disabled');this.disabled=false;
        },
        disable:function(){
            this.element.attr('disabled',true).siblings().attr('disabled',true).parent().addClass('ui-spinner-disabled');this.disabled=true;
        }
    });$.extend($.ui.spinner,{
        defaults:{
            stepping:1,
            start:0,
            incremental:true,
            currency:false
        },
        format:{
            number:function(num,dec){
                return this.round(num,dec);
            },
            currency:function(num,sym){
                return(num!==Math.abs(num)?'-':'')+sym+this.round(Math.abs(num),2);
            },
            round:function(num,dec){
                var s=Math.round(parseFloat(num)*Math.pow(10,dec))/Math.pow(10,dec);if(dec>0){
                    s=s+((s.toString().indexOf('.')==-1)?'.':'')+'0000000001';s=s.substr(0,s.indexOf('.')+1+dec);
                }else{
                    s=Math.round(s);
                }
                return s;
            }
        }
    });
})(jQuery);;(function($){
    $.effects=$.effects||{};$.extend($.effects,{
        save:function(el,set){
            for(var i=0;i<set.length;i++){
                if(set[i]!==null)$.data(el[0],"ec.storage."+set[i],el[0].style[set[i]]);
            }
        },
        restore:function(el,set){
            for(var i=0;i<set.length;i++){
                if(set[i]!==null)el.css(set[i],$.data(el[0],"ec.storage."+set[i]));
            }
        },
        setMode:function(el,mode){
            if(mode=='toggle')mode=el.is(':hidden')?'show':'hide';return mode;
        },
        getBaseline:function(origin,original){
            var y,x;switch(origin[0]){
                case'top':y=0;break;case'middle':y=0.5;break;case'bottom':y=1;break;default:y=origin[0]/original.height;
            };switch(origin[1]){
                case'left':x=0;break;case'center':x=0.5;break;case'right':x=1;break;default:x=origin[1]/original.width;
            };return{
                x:x,
                y:y
            };
        },
        createWrapper:function(el){
            if(el.parent().attr('id')=='fxWrapper')
                return el;var props={
                width:el.outerWidth({
                    margin:true
                }),
                height:el.outerHeight({
                    margin:true
                }),
                'float':el.css('float')
            };el.wrap('<div id="fxWrapper" style="font-size:100%;background:transparent;border:none;margin:0;padding:0"></div>');var wrapper=el.parent();if(el.css('position')=='static'){
                wrapper.css({
                    position:'relative'
                });el.css({
                    position:'relative'
                });
            }else{
                var top=el.css('top');if(isNaN(parseInt(top)))top='auto';var left=el.css('left');if(isNaN(parseInt(left)))left='auto';wrapper.css({
                    position:el.css('position'),
                    top:top,
                    left:left,
                    zIndex:el.css('z-index')
                }).show();el.css({
                    position:'relative',
                    top:0,
                    left:0
                });
            }
            wrapper.css(props);return wrapper;
        },
        removeWrapper:function(el){
            if(el.parent().attr('id')=='fxWrapper')
                return el.parent().replaceWith(el);return el;
        },
        setTransition:function(el,list,factor,val){
            val=val||{};$.each(list,function(i,x){
                unit=el.cssUnit(x);if(unit[0]>0)val[x]=unit[0]*factor+unit[1];
            });return val;
        },
        animateClass:function(value,duration,easing,callback){
            var cb=(typeof easing=="function"?easing:(callback?callback:null));var ea=(typeof easing=="object"?easing:null);return this.each(function(){
                var offset={};var that=$(this);var oldStyleAttr=that.attr("style")||'';if(typeof oldStyleAttr=='object')oldStyleAttr=oldStyleAttr["cssText"];if(value.toggle){
                    that.hasClass(value.toggle)?value.remove=value.toggle:value.add=value.toggle;
                }
                var oldStyle=$.extend({},(document.defaultView?document.defaultView.getComputedStyle(this,null):this.currentStyle));if(value.add)that.addClass(value.add);if(value.remove)that.removeClass(value.remove);var newStyle=$.extend({},(document.defaultView?document.defaultView.getComputedStyle(this,null):this.currentStyle));if(value.add)that.removeClass(value.add);if(value.remove)that.addClass(value.remove);for(var n in newStyle){
                    if(typeof newStyle[n]!="function"&&newStyle[n]&&n.indexOf("Moz")==-1&&n.indexOf("length")==-1&&newStyle[n]!=oldStyle[n]&&(n.match(/color/i)||(!n.match(/color/i)&&!isNaN(parseInt(newStyle[n],10))))&&(oldStyle.position!="static"||(oldStyle.position=="static"&&!n.match(/left|top|bottom|right/))))offset[n]=newStyle[n];
                }
                that.animate(offset,duration,ea,function(){
                    if(typeof $(this).attr("style")=='object'){
                        $(this).attr("style")["cssText"]="";$(this).attr("style")["cssText"]=oldStyleAttr;
                    }else $(this).attr("style",oldStyleAttr);if(value.add)$(this).addClass(value.add);if(value.remove)$(this).removeClass(value.remove);if(cb)cb.apply(this,arguments);
                });
            });
        }
    });$.fn.extend({
        _show:$.fn.show,
        _hide:$.fn.hide,
        __toggle:$.fn.toggle,
        _addClass:$.fn.addClass,
        _removeClass:$.fn.removeClass,
        _toggleClass:$.fn.toggleClass,
        effect:function(fx,o,speed,callback){
            return $.effects[fx]?$.effects[fx].call(this,{
                method:fx,
                options:o||{},
                duration:speed,
                callback:callback
            }):null;
        },
        show:function(){
            if(!arguments[0]||(arguments[0].constructor==Number||/(slow|normal|fast)/.test(arguments[0])))
                return this._show.apply(this,arguments);else{
                var o=arguments[1]||{};o['mode']='show';return this.effect.apply(this,[arguments[0],o,arguments[2]||o.duration,arguments[3]||o.callback]);
            }
        },
        hide:function(){
            if(!arguments[0]||(arguments[0].constructor==Number||/(slow|normal|fast)/.test(arguments[0])))
                return this._hide.apply(this,arguments);else{
                var o=arguments[1]||{};o['mode']='hide';return this.effect.apply(this,[arguments[0],o,arguments[2]||o.duration,arguments[3]||o.callback]);
            }
        },
        toggle:function(){
            if(!arguments[0]||(arguments[0].constructor==Number||/(slow|normal|fast)/.test(arguments[0]))||(arguments[0].constructor==Function))
                return this.__toggle.apply(this,arguments);else{
                var o=arguments[1]||{};o['mode']='toggle';return this.effect.apply(this,[arguments[0],o,arguments[2]||o.duration,arguments[3]||o.callback]);
            }
        },
        addClass:function(classNames,speed,easing,callback){
            return speed?$.effects.animateClass.apply(this,[{
                add:classNames
            },speed,easing,callback]):this._addClass(classNames);
        },
        removeClass:function(classNames,speed,easing,callback){
            return speed?$.effects.animateClass.apply(this,[{
                remove:classNames
            },speed,easing,callback]):this._removeClass(classNames);
        },
        toggleClass:function(classNames,speed,easing,callback){
            return speed?$.effects.animateClass.apply(this,[{
                toggle:classNames
            },speed,easing,callback]):this._toggleClass(classNames);
        },
        morph:function(remove,add,speed,easing,callback){
            return $.effects.animateClass.apply(this,[{
                add:add,
                remove:remove
            },speed,easing,callback]);
        },
        switchClass:function(){
            return this.morph.apply(this,arguments);
        },
        cssUnit:function(key){
            var style=this.css(key),val=[];$.each(['em','px','%','pt'],function(i,unit){
                if(style.indexOf(unit)>0)
                    val=[parseFloat(style),unit];
            });return val;
        }
    });jQuery.each(['backgroundColor','borderBottomColor','borderLeftColor','borderRightColor','borderTopColor','color','outlineColor'],function(i,attr){
        jQuery.fx.step[attr]=function(fx){
            if(fx.state==0){
                fx.start=getColor(fx.elem,attr);fx.end=getRGB(fx.end);
            }
            fx.elem.style[attr]="rgb("+[Math.max(Math.min(parseInt((fx.pos*(fx.end[0]-fx.start[0]))+fx.start[0]),255),0),Math.max(Math.min(parseInt((fx.pos*(fx.end[1]-fx.start[1]))+fx.start[1]),255),0),Math.max(Math.min(parseInt((fx.pos*(fx.end[2]-fx.start[2]))+fx.start[2]),255),0)].join(",")+")";
        }
    });function getRGB(color){
        var result;if(color&&color.constructor==Array&&color.length==3)
            return color;if(result=/rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(color))
            return[parseInt(result[1]),parseInt(result[2]),parseInt(result[3])];if(result=/rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(color))
            return[parseFloat(result[1])*2.55,parseFloat(result[2])*2.55,parseFloat(result[3])*2.55];if(result=/#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(color))
            return[parseInt(result[1],16),parseInt(result[2],16),parseInt(result[3],16)];if(result=/#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(color))
            return[parseInt(result[1]+result[1],16),parseInt(result[2]+result[2],16),parseInt(result[3]+result[3],16)];if(result=/rgba\(0, 0, 0, 0\)/.exec(color))
            return colors['transparent']
        return colors[jQuery.trim(color).toLowerCase()];
    }
    function getColor(elem,attr){
        var color;do{
            color=jQuery.curCSS(elem,attr);if(color!=''&&color!='transparent'||jQuery.nodeName(elem,"body"))
                break;attr="backgroundColor";
        }while(elem=elem.parentNode);return getRGB(color);
    };var colors={
        aqua:[0,255,255],
        azure:[240,255,255],
        beige:[245,245,220],
        black:[0,0,0],
        blue:[0,0,255],
        brown:[165,42,42],
        cyan:[0,255,255],
        darkblue:[0,0,139],
        darkcyan:[0,139,139],
        darkgrey:[169,169,169],
        darkgreen:[0,100,0],
        darkkhaki:[189,183,107],
        darkmagenta:[139,0,139],
        darkolivegreen:[85,107,47],
        darkorange:[255,140,0],
        darkorchid:[153,50,204],
        darkred:[139,0,0],
        darksalmon:[233,150,122],
        darkviolet:[148,0,211],
        fuchsia:[255,0,255],
        gold:[255,215,0],
        green:[0,128,0],
        indigo:[75,0,130],
        khaki:[240,230,140],
        lightblue:[173,216,230],
        lightcyan:[224,255,255],
        lightgreen:[144,238,144],
        lightgrey:[211,211,211],
        lightpink:[255,182,193],
        lightyellow:[255,255,224],
        lime:[0,255,0],
        magenta:[255,0,255],
        maroon:[128,0,0],
        navy:[0,0,128],
        olive:[128,128,0],
        orange:[255,165,0],
        pink:[255,192,203],
        purple:[128,0,128],
        violet:[128,0,128],
        red:[255,0,0],
        silver:[192,192,192],
        white:[255,255,255],
        yellow:[255,255,0],
        transparent:[255,255,255]
    };jQuery.easing['jswing']=jQuery.easing['swing'];jQuery.extend(jQuery.easing,{
        def:'easeOutQuad',
        swing:function(x,t,b,c,d){
            return jQuery.easing[jQuery.easing.def](x,t,b,c,d);
        },
        easeInQuad:function(x,t,b,c,d){
            return c*(t/=d)*t+b;
        },
        easeOutQuad:function(x,t,b,c,d){
            return-c*(t/=d)*(t-2)+b;
        },
        easeInOutQuad:function(x,t,b,c,d){
            if((t/=d/2)<1)return c/2*t*t+b;return-c/2*((--t)*(t-2)-1)+b;
        },
        easeInCubic:function(x,t,b,c,d){
            return c*(t/=d)*t*t+b;
        },
        easeOutCubic:function(x,t,b,c,d){
            return c*((t=t/d-1)*t*t+1)+b;
        },
        easeInOutCubic:function(x,t,b,c,d){
            if((t/=d/2)<1)return c/2*t*t*t+b;return c/2*((t-=2)*t*t+2)+b;
        },
        easeInQuart:function(x,t,b,c,d){
            return c*(t/=d)*t*t*t+b;
        },
        easeOutQuart:function(x,t,b,c,d){
            return-c*((t=t/d-1)*t*t*t-1)+b;
        },
        easeInOutQuart:function(x,t,b,c,d){
            if((t/=d/2)<1)return c/2*t*t*t*t+b;return-c/2*((t-=2)*t*t*t-2)+b;
        },
        easeInQuint:function(x,t,b,c,d){
            return c*(t/=d)*t*t*t*t+b;
        },
        easeOutQuint:function(x,t,b,c,d){
            return c*((t=t/d-1)*t*t*t*t+1)+b;
        },
        easeInOutQuint:function(x,t,b,c,d){
            if((t/=d/2)<1)return c/2*t*t*t*t*t+b;return c/2*((t-=2)*t*t*t*t+2)+b;
        },
        easeInSine:function(x,t,b,c,d){
            return-c*Math.cos(t/d*(Math.PI/2))+c+b;
        },
        easeOutSine:function(x,t,b,c,d){
            return c*Math.sin(t/d*(Math.PI/2))+b;
        },
        easeInOutSine:function(x,t,b,c,d){
            return-c/2*(Math.cos(Math.PI*t/d)-1)+b;
        },
        easeInExpo:function(x,t,b,c,d){
            return(t==0)?b:c*Math.pow(2,10*(t/d-1))+b;
        },
        easeOutExpo:function(x,t,b,c,d){
            return(t==d)?b+c:c*(-Math.pow(2,-10*t/d)+1)+b;
        },
        easeInOutExpo:function(x,t,b,c,d){
            if(t==0)return b;if(t==d)return b+c;if((t/=d/2)<1)return c/2*Math.pow(2,10*(t-1))+b;return c/2*(-Math.pow(2,-10*--t)+2)+b;
        },
        easeInCirc:function(x,t,b,c,d){
            return-c*(Math.sqrt(1-(t/=d)*t)-1)+b;
        },
        easeOutCirc:function(x,t,b,c,d){
            return c*Math.sqrt(1-(t=t/d-1)*t)+b;
        },
        easeInOutCirc:function(x,t,b,c,d){
            if((t/=d/2)<1)return-c/2*(Math.sqrt(1-t*t)-1)+b;return c/2*(Math.sqrt(1-(t-=2)*t)+1)+b;
        },
        easeInElastic:function(x,t,b,c,d){
            var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d)==1)return b+c;if(!p)p=d*.3;if(a<Math.abs(c)){
                a=c;var s=p/4;
            }
            else var s=p/(2*Math.PI)*Math.asin(c/a);return-(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b;
        },
        easeOutElastic:function(x,t,b,c,d){
            var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d)==1)return b+c;if(!p)p=d*.3;if(a<Math.abs(c)){
                a=c;var s=p/4;
            }
            else var s=p/(2*Math.PI)*Math.asin(c/a);return a*Math.pow(2,-10*t)*Math.sin((t*d-s)*(2*Math.PI)/p)+c+b;
        },
        easeInOutElastic:function(x,t,b,c,d){
            var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d/2)==2)return b+c;if(!p)p=d*(.3*1.5);if(a<Math.abs(c)){
                a=c;var s=p/4;
            }
            else var s=p/(2*Math.PI)*Math.asin(c/a);if(t<1)return-.5*(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b;return a*Math.pow(2,-10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p)*.5+c+b;
        },
        easeInBack:function(x,t,b,c,d,s){
            if(s==undefined)s=1.70158;return c*(t/=d)*t*((s+1)*t-s)+b;
        },
        easeOutBack:function(x,t,b,c,d,s){
            if(s==undefined)s=1.70158;return c*((t=t/d-1)*t*((s+1)*t+s)+1)+b;
        },
        easeInOutBack:function(x,t,b,c,d,s){
            if(s==undefined)s=1.70158;if((t/=d/2)<1)return c/2*(t*t*(((s*=(1.525))+1)*t-s))+b;return c/2*((t-=2)*t*(((s*=(1.525))+1)*t+s)+2)+b;
        },
        easeInBounce:function(x,t,b,c,d){
            return c-jQuery.easing.easeOutBounce(x,d-t,0,c,d)+b;
        },
        easeOutBounce:function(x,t,b,c,d){
            if((t/=d)<(1/2.75)){
                return c*(7.5625*t*t)+b;
            }else if(t<(2/2.75)){
                return c*(7.5625*(t-=(1.5/2.75))*t+.75)+b;
            }else if(t<(2.5/2.75)){
                return c*(7.5625*(t-=(2.25/2.75))*t+.9375)+b;
            }else{
                return c*(7.5625*(t-=(2.625/2.75))*t+.984375)+b;
            }
        },
        easeInOutBounce:function(x,t,b,c,d){
            if(t<d/2)return jQuery.easing.easeInBounce(x,t*2,0,c,d)*.5+b;return jQuery.easing.easeOutBounce(x,t*2-d,0,c,d)*.5+c*.5+b;
        }
    });
})(jQuery);(function($){
    $.effects.blind=function(o){
        return this.queue(function(){
            var el=$(this),props=['position','top','left'];var mode=$.effects.setMode(el,o.options.mode||'hide');var direction=o.options.direction||'vertical';$.effects.save(el,props);el.show();var wrapper=$.effects.createWrapper(el).css({
                overflow:'hidden'
            });var ref=(direction=='vertical')?'height':'width';var distance=(direction=='vertical')?wrapper.height():wrapper.width();if(mode=='show')wrapper.css(ref,0);var animation={};animation[ref]=mode=='show'?distance:0;wrapper.animate(animation,o.duration,o.options.easing,function(){
                if(mode=='hide')el.hide();$.effects.restore(el,props);$.effects.removeWrapper(el);if(o.callback)o.callback.apply(el[0],arguments);el.dequeue();
            });
        });
    };
})(jQuery);(function($){
    $.effects.bounce=function(o){
        return this.queue(function(){
            var el=$(this),props=['position','top','left'];var mode=$.effects.setMode(el,o.options.mode||'effect');var direction=o.options.direction||'up';var distance=o.options.distance||20;var times=o.options.times||5;var speed=o.duration||250;if(/show|hide/.test(mode))props.push('opacity');$.effects.save(el,props);el.show();$.effects.createWrapper(el);var ref=(direction=='up'||direction=='down')?'top':'left';var motion=(direction=='up'||direction=='left')?'pos':'neg';var distance=o.options.distance||(ref=='top'?el.outerHeight({
                margin:true
            })/3:el.outerWidth({
                margin:true
            })/3);if(mode=='show')el.css('opacity',0).css(ref,motion=='pos'?-distance:distance);if(mode=='hide')distance=distance/(times*2);if(mode!='hide')times--;if(mode=='show'){
                var animation={
                    opacity:1
                };animation[ref]=(motion=='pos'?'+=':'-=')+distance;el.animate(animation,speed/2,o.options.easing);distance=distance/2;times--;
            };for(var i=0;i<times;i++){
                var animation1={},animation2={};animation1[ref]=(motion=='pos'?'-=':'+=')+distance;animation2[ref]=(motion=='pos'?'+=':'-=')+distance;el.animate(animation1,speed/2,o.options.easing).animate(animation2,speed/2,o.options.easing);distance=(mode=='hide')?distance*2:distance/2;
            };if(mode=='hide'){
                var animation={
                    opacity:0
                };animation[ref]=(motion=='pos'?'-=':'+=')+distance;el.animate(animation,speed/2,o.options.easing,function(){
                    el.hide();$.effects.restore(el,props);$.effects.removeWrapper(el);if(o.callback)o.callback.apply(this,arguments);
                });
            }else{
                var animation1={},animation2={};animation1[ref]=(motion=='pos'?'-=':'+=')+distance;animation2[ref]=(motion=='pos'?'+=':'-=')+distance;el.animate(animation1,speed/2,o.options.easing).animate(animation2,speed/2,o.options.easing,function(){
                    $.effects.restore(el,props);$.effects.removeWrapper(el);if(o.callback)o.callback.apply(this,arguments);
                });
            };el.queue('fx',function(){
                el.dequeue();
            });el.dequeue();
        });
    };
})(jQuery);(function($){

    $.effects.clip=function(o){
        return this.queue(function(){
            var el=$(this),props=['position','top','left','height','width'];var mode=$.effects.setMode(el,o.options.mode||'hide');var direction=o.options.direction||'vertical';$.effects.save(el,props);el.show();var wrapper=$.effects.createWrapper(el).css({
                overflow:'hidden'
            });var animate=el[0].tagName=='IMG'?wrapper:el;var ref={
                size:(direction=='vertical')?'height':'width',
                position:(direction=='vertical')?'top':'left'
            };var distance=(direction=='vertical')?animate.height():animate.width();if(mode=='show'){
                animate.css(ref.size,0);animate.css(ref.position,distance/2);
            }
            var animation={};animation[ref.size]=mode=='show'?distance:0;animation[ref.position]=mode=='show'?0:distance/2;animate.animate(animation,{
                queue:false,
                duration:o.duration,
                easing:o.options.easing,
                complete:function(){
                    if(mode=='hide')el.hide();$.effects.restore(el,props);$.effects.removeWrapper(el);if(o.callback)o.callback.apply(el[0],arguments);el.dequeue();
                }
            });
        });
    };
})(jQuery);(function($){
    $.effects.drop=function(o){
        return this.queue(function(){
            var el=$(this),props=['position','top','left','opacity'];var mode=$.effects.setMode(el,o.options.mode||'hide');var direction=o.options.direction||'left';$.effects.save(el,props);el.show();$.effects.createWrapper(el);var ref=(direction=='up'||direction=='down')?'top':'left';var motion=(direction=='up'||direction=='left')?'pos':'neg';var distance=o.options.distance||(ref=='top'?el.outerHeight({
                margin:true
            })/2:el.outerWidth({
                margin:true
            })/2);if(mode=='show')el.css('opacity',0).css(ref,motion=='pos'?-distance:distance);var animation={
                opacity:mode=='show'?1:0
            };animation[ref]=(mode=='show'?(motion=='pos'?'+=':'-='):(motion=='pos'?'-=':'+='))+distance;el.animate(animation,{
                queue:false,
                duration:o.duration,
                easing:o.options.easing,
                complete:function(){
                    if(mode=='hide')el.hide();$.effects.restore(el,props);$.effects.removeWrapper(el);if(o.callback)o.callback.apply(this,arguments);el.dequeue();
                }
            });
        });
    };
})(jQuery);(function($){
    $.effects.explode=function(o){
        return this.queue(function(){
            var rows=o.options.pieces?Math.round(Math.sqrt(o.options.pieces)):3;var cells=o.options.pieces?Math.round(Math.sqrt(o.options.pieces)):3;o.options.mode=o.options.mode=='toggle'?($(this).is(':visible')?'hide':'show'):o.options.mode;var el=$(this).show().css('visibility','hidden');var offset=el.offset();offset.top-=parseInt(el.css("marginTop"))||0;offset.left-=parseInt(el.css("marginLeft"))||0;var width=el.outerWidth(true);var height=el.outerHeight(true);for(var i=0;i<rows;i++){
                for(var j=0;j<cells;j++){
                    el.clone().appendTo('body').wrap('<div></div>').css({
                        position:'absolute',
                        visibility:'visible',
                        left:-j*(width/cells),
                        top:-i*(height/rows)
                    }).parent().addClass('effects-explode').css({
                        position:'absolute',
                        overflow:'hidden',
                        width:width/cells,
                        height:height/rows,
                        left:offset.left+j*(width/cells)+(o.options.mode=='show'?(j-Math.floor(cells/2))*(width/cells):0),
                        top:offset.top+i*(height/rows)+(o.options.mode=='show'?(i-Math.floor(rows/2))*(height/rows):0),
                        opacity:o.options.mode=='show'?0:1
                    }).animate({
                        left:offset.left+j*(width/cells)+(o.options.mode=='show'?0:(j-Math.floor(cells/2))*(width/cells)),
                        top:offset.top+i*(height/rows)+(o.options.mode=='show'?0:(i-Math.floor(rows/2))*(height/rows)),
                        opacity:o.options.mode=='show'?1:0
                    },o.duration||500);
                }
            }
            setTimeout(function(){
                o.options.mode=='show'?el.css({
                    visibility:'visible'
                }):el.css({
                    visibility:'visible'
                }).hide();if(o.callback)o.callback.apply(el[0]);el.dequeue();$('.effects-explode').remove();
            },o.duration||500);
        });
    };
})(jQuery);(function($){
    $.effects.fold=function(o){
        return this.queue(function(){
            var el=$(this),props=['position','top','left'];var mode=$.effects.setMode(el,o.options.mode||'hide');var size=o.options.size||15;var horizFirst=!(!o.options.horizFirst);$.effects.save(el,props);el.show();var wrapper=$.effects.createWrapper(el).css({
                overflow:'hidden'
            });var widthFirst=((mode=='show')!=horizFirst);var ref=widthFirst?['width','height']:['height','width'];var distance=widthFirst?[wrapper.width(),wrapper.height()]:[wrapper.height(),wrapper.width()];var percent=/([0-9]+)%/.exec(size);if(percent)size=parseInt(percent[1])/100*distance[mode=='hide'?0:1];if(mode=='show')wrapper.css(horizFirst?{
                height:0,
                width:size
            }:{
                height:size,
                width:0
            });var animation1={},animation2={};animation1[ref[0]]=mode=='show'?distance[0]:size;animation2[ref[1]]=mode=='show'?distance[1]:0;wrapper.animate(animation1,o.duration/2,o.options.easing).animate(animation2,o.duration/2,o.options.easing,function(){
                if(mode=='hide')el.hide();$.effects.restore(el,props);$.effects.removeWrapper(el);if(o.callback)o.callback.apply(el[0],arguments);el.dequeue();
            });
        });
    };
})(jQuery);;(function($){
    $.effects.highlight=function(o){
        return this.queue(function(){
            var el=$(this),props=['backgroundImage','backgroundColor','opacity'];var mode=$.effects.setMode(el,o.options.mode||'show');var color=o.options.color||"#ffff99";var oldColor=el.css("backgroundColor");$.effects.save(el,props);el.show();el.css({
                backgroundImage:'none',
                backgroundColor:color
            });var animation={
                backgroundColor:oldColor
            };if(mode=="hide")animation['opacity']=0;el.animate(animation,{
                queue:false,
                duration:o.duration,
                easing:o.options.easing,
                complete:function(){
                    if(mode=="hide")el.hide();$.effects.restore(el,props);if(mode=="show"&&jQuery.browser.msie)this.style.removeAttribute('filter');if(o.callback)o.callback.apply(this,arguments);el.dequeue();
                }
            });
        });
    };
})(jQuery);(function($){
    $.effects.pulsate=function(o){
        return this.queue(function(){
            var el=$(this);var mode=$.effects.setMode(el,o.options.mode||'show');var times=o.options.times||5;if(mode=='hide')times--;if(el.is(':hidden')){
                el.css('opacity',0);el.show();el.animate({
                    opacity:1
                },o.duration/2,o.options.easing);times=times-2;
            }
            for(var i=0;i<times;i++){
                el.animate({
                    opacity:0
                },o.duration/2,o.options.easing).animate({
                    opacity:1
                },o.duration/2,o.options.easing);
            };if(mode=='hide'){
                el.animate({
                    opacity:0
                },o.duration/2,o.options.easing,function(){
                    el.hide();if(o.callback)o.callback.apply(this,arguments);
                });
            }else{
                el.animate({
                    opacity:0
                },o.duration/2,o.options.easing).animate({
                    opacity:1
                },o.duration/2,o.options.easing,function(){
                    if(o.callback)o.callback.apply(this,arguments);
                });
            };el.queue('fx',function(){
                el.dequeue();
            });el.dequeue();
        });
    };
})(jQuery);(function($){
    $.effects.puff=function(o){
        return this.queue(function(){
            var el=$(this);var options=$.extend(true,{},o.options);var mode=$.effects.setMode(el,o.options.mode||'hide');var percent=parseInt(o.options.percent)||150;options.fade=true;var original={
                height:el.height(),
                width:el.width()
            };var factor=percent/100;el.from=(mode=='hide')?original:{
                height:original.height*factor,
                width:original.width*factor
            };options.from=el.from;options.percent=(mode=='hide')?percent:100;options.mode=mode;el.effect('scale',options,o.duration,o.callback);el.dequeue();
        });
    };$.effects.scale=function(o){
        return this.queue(function(){
            var el=$(this);var options=$.extend(true,{},o.options);var mode=$.effects.setMode(el,o.options.mode||'effect');var percent=parseInt(o.options.percent)||(parseInt(o.options.percent)==0?0:(mode=='hide'?0:100));var direction=o.options.direction||'both';var origin=o.options.origin;if(mode!='effect'){
                options.origin=origin||['middle','center'];options.restore=true;
            }
            var original={
                height:el.height(),
                width:el.width()
            };el.from=o.options.from||(mode=='show'?{
                height:0,
                width:0
            }:original);var factor={
                y:direction!='horizontal'?(percent/100):1,
                x:direction!='vertical'?(percent/100):1
            };el.to={
                height:original.height*factor.y,
                width:original.width*factor.x
            };if(o.options.fade){
                if(mode=='show'){
                    el.from.opacity=0;el.to.opacity=1;
                };if(mode=='hide'){
                    el.from.opacity=1;el.to.opacity=0;
                };
            };options.from=el.from;options.to=el.to;options.mode=mode;el.effect('size',options,o.duration,o.callback);el.dequeue();
        });
    };$.effects.size=function(o){
        return this.queue(function(){
            var el=$(this),props=['position','top','left','width','height','overflow','opacity'];var props1=['position','top','left','overflow','opacity'];var props2=['width','height','overflow'];var cProps=['fontSize'];var vProps=['borderTopWidth','borderBottomWidth','paddingTop','paddingBottom'];var hProps=['borderLeftWidth','borderRightWidth','paddingLeft','paddingRight'];var mode=$.effects.setMode(el,o.options.mode||'effect');var restore=o.options.restore||false;var scale=o.options.scale||'both';var origin=o.options.origin;var original={
                height:el.height(),
                width:el.width()
            };el.from=o.options.from||original;el.to=o.options.to||original;if(origin){
                var baseline=$.effects.getBaseline(origin,original);el.from.top=(original.height-el.from.height)*baseline.y;el.from.left=(original.width-el.from.width)*baseline.x;el.to.top=(original.height-el.to.height)*baseline.y;el.to.left=(original.width-el.to.width)*baseline.x;
            };var factor={
                from:{
                    y:el.from.height/original.height,
                    x:el.from.width/original.width
                },
                to:{
                    y:el.to.height/original.height,
                    x:el.to.width/original.width
                }
            };if(scale=='box'||scale=='both'){
                if(factor.from.y!=factor.to.y){
                    props=props.concat(vProps);el.from=$.effects.setTransition(el,vProps,factor.from.y,el.from);el.to=$.effects.setTransition(el,vProps,factor.to.y,el.to);
                };if(factor.from.x!=factor.to.x){
                    props=props.concat(hProps);el.from=$.effects.setTransition(el,hProps,factor.from.x,el.from);el.to=$.effects.setTransition(el,hProps,factor.to.x,el.to);
                };
            };if(scale=='content'||scale=='both'){
                if(factor.from.y!=factor.to.y){
                    props=props.concat(cProps);el.from=$.effects.setTransition(el,cProps,factor.from.y,el.from);el.to=$.effects.setTransition(el,cProps,factor.to.y,el.to);
                };
            };$.effects.save(el,restore?props:props1);el.show();$.effects.createWrapper(el);el.css('overflow','hidden').css(el.from);if(scale=='content'||scale=='both'){
                vProps=vProps.concat(['marginTop','marginBottom']).concat(cProps);hProps=hProps.concat(['marginLeft','marginRight']);props2=props.concat(vProps).concat(hProps);el.find("*[width]").each(function(){
                    child=$(this);if(restore)$.effects.save(child,props2);var c_original={
                        height:child.height(),
                        width:child.width()
                    };child.from={
                        height:c_original.height*factor.from.y,
                        width:c_original.width*factor.from.x
                    };child.to={
                        height:c_original.height*factor.to.y,
                        width:c_original.width*factor.to.x
                    };if(factor.from.y!=factor.to.y){
                        child.from=$.effects.setTransition(child,vProps,factor.from.y,child.from);child.to=$.effects.setTransition(child,vProps,factor.to.y,child.to);
                    };if(factor.from.x!=factor.to.x){
                        child.from=$.effects.setTransition(child,hProps,factor.from.x,child.from);child.to=$.effects.setTransition(child,hProps,factor.to.x,child.to);
                    };child.css(child.from);child.animate(child.to,o.duration,o.options.easing,function(){
                        if(restore)$.effects.restore(child,props2);
                    });
                });
            };el.animate(el.to,{
                queue:false,
                duration:o.duration,
                easing:o.options.easing,
                complete:function(){
                    if(mode=='hide')el.hide();$.effects.restore(el,restore?props:props1);$.effects.removeWrapper(el);if(o.callback)o.callback.apply(this,arguments);el.dequeue();
                }
            });
        });
    };
})(jQuery);(function($){
    $.effects.shake=function(o){
        return this.queue(function(){
            var el=$(this),props=['position','top','left'];var mode=$.effects.setMode(el,o.options.mode||'effect');var direction=o.options.direction||'left';var distance=o.options.distance||20;var times=o.options.times||3;var speed=o.duration||o.options.duration||140;$.effects.save(el,props);el.show();$.effects.createWrapper(el);var ref=(direction=='up'||direction=='down')?'top':'left';var motion=(direction=='up'||direction=='left')?'pos':'neg';var animation={},animation1={},animation2={};animation[ref]=(motion=='pos'?'-=':'+=')+distance;animation1[ref]=(motion=='pos'?'+=':'-=')+distance*2;animation2[ref]=(motion=='pos'?'-=':'+=')+distance*2;el.animate(animation,speed,o.options.easing);for(var i=1;i<times;i++){
                el.animate(animation1,speed,o.options.easing).animate(animation2,speed,o.options.easing);
            };el.animate(animation1,speed,o.options.easing).animate(animation,speed/2,o.options.easing,function(){
                $.effects.restore(el,props);$.effects.removeWrapper(el);if(o.callback)o.callback.apply(this,arguments);
            });el.queue('fx',function(){
                el.dequeue();
            });el.dequeue();
        });
    };
})(jQuery);(function($){
    $.effects.slide=function(o){
        return this.queue(function(){
            var el=$(this),props=['position','top','left'];var mode=$.effects.setMode(el,o.options.mode||'show');var direction=o.options.direction||'left';$.effects.save(el,props);el.show();$.effects.createWrapper(el).css({
                overflow:'hidden'
            });var ref=(direction=='up'||direction=='down')?'top':'left';var motion=(direction=='up'||direction=='left')?'pos':'neg';var distance=o.options.distance||(ref=='top'?el.outerHeight({
                margin:true
            }):el.outerWidth({
                margin:true
            }));if(mode=='show')el.css(ref,motion=='pos'?-distance:distance);var animation={};animation[ref]=(mode=='show'?(motion=='pos'?'+=':'-='):(motion=='pos'?'-=':'+='))+distance;el.animate(animation,{
                queue:false,
                duration:o.duration,
                easing:o.options.easing,
                complete:function(){
                    if(mode=='hide')el.hide();$.effects.restore(el,props);$.effects.removeWrapper(el);if(o.callback)o.callback.apply(this,arguments);el.dequeue();
                }
            });
        });
    };
})(jQuery);(function($){
    $.effects.transfer=function(o){
        return this.queue(function(){
            var el=$(this);var mode=$.effects.setMode(el,o.options.mode||'effect');var target=$(o.options.to);var position=el.offset();var transfer=$('<div class="ui-effects-transfer"></div>').appendTo(document.body);if(o.options.className)transfer.addClass(o.options.className);transfer.addClass(o.options.className);transfer.css({
                top:position.top,
                left:position.left,
                height:el.outerHeight()-parseInt(transfer.css('borderTopWidth'))-parseInt(transfer.css('borderBottomWidth')),
                width:el.outerWidth()-parseInt(transfer.css('borderLeftWidth'))-parseInt(transfer.css('borderRightWidth')),
                position:'absolute'
            });position=target.offset();animation={
                top:position.top,
                left:position.left,
                height:target.outerHeight()-parseInt(transfer.css('borderTopWidth'))-parseInt(transfer.css('borderBottomWidth')),
                width:target.outerWidth()-parseInt(transfer.css('borderLeftWidth'))-parseInt(transfer.css('borderRightWidth'))
            };transfer.animate(animation,o.duration,o.options.easing,function(){
                transfer.remove();if(o.callback)o.callback.apply(el[0],arguments);el.dequeue();
            });
        });
    };
})(jQuery);