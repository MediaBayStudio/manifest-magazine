var errorPopup,thanksPopup,mask,lazy,menu,burger,hdr,overlay,body,fakeScrollbar,mobileMenu,browser={isOpera:!!window.opr&&!!opr.addons||!!window.opera||0<=navigator.userAgent.indexOf(" OPR/"),isFirefox:"undefined"!=typeof InstallTrigger,isSafari:/constructor/i.test(window.HTMLElement)||"[object SafariRemoteNotification]"===(!window.safari||"undefined"!=typeof safari&&safari.pushNotification).toString(),isIE:!!document.documentMode,isEdge:!document.documentMode&&!!window.StyleMedia,isChrome:!!window.chrome&&!!window.chrome.webstore,isYandex:!!window.yandex,isMac:0<=window.navigator.platform.toUpperCase().indexOf("MAC")},SLIDER={hasSlickClass:function(e){return e.hasClass("slick-slider")},unslick:function(e){e.slick("unslick")},createArrow:function(e,t){return'<button type="button" class="arrow arrow_'+(e=(-1===e.indexOf("prev")?"next ":"prev ")+e)+'">'+t+"</button>"},arrowSvg:'<svg class="arrow__svg" viewBox="0 0 50 30" xmlns="http://www.w3.org/2000/svg" fill="none"><path class="arrow-path" fill-rule="evenodd" clip-rule="evenodd" d="M38.589 14l-5.018-4.157.429-.51 6 5.014-6 4.986-.43-.509 5.019-4.157h-38.589v-.667h38.589z" fill="currentColor"/><circle r="14.5" transform="matrix(-1 0 0 1 35 15)" stroke="currentColor"/></svg>'},windowFuncs={load:[],resize:[],scroll:[],call:function(e){for(var t=windowFuncs[e.type]||e,o=t.length-1;0<=o;o--)t[o]()}},copyInputValue=function(){var e=document.createElement("input");e.setAttribute("type","text"),e.style.opacity=0,document.body.appendChild(e),e.value=event.target.value,e.select(),document.execCommand("copy"),document.body.removeChild(e)},q=function(e,t){return(t=t||document.body).querySelector(e)},qa=function(e,t,o){return t=t||document.body,o?Array.prototype.slice.call(t.querySelectorAll(e)):t.querySelectorAll(e)},id=function(e){return document.getElementById(e)},setVh=function(){var e=.01*window.innerHeight;document.documentElement.style.setProperty("--vh",e+"px")},media=function(e){return window.matchMedia(e).matches},scrollToTarget=function(e,t){var o,n,r,i,l;e&&e.preventDefault(),_=this===window?e.target:this,t||0==(t=t||_.getAttribute("data-scroll-target"))&&(t=document.body),(t=(t=!t&&"A"===_.tagName?q(_.getAttribute("href")):t).constructor===String?q(t):t)&&(menu&&menu.close(),o=window.pageYOffset,getComputedStyle(t),n=t.getBoundingClientRect().top,r=null,i=3e3<Math.abs(n)?.15:.35,l=function(e){e-=r=null===r?e:r,e=n<0?Math.max(o-e/i,o+n):Math.min(o+e/i,o+n);window.scrollTo(0,e),e!=o+n&&requestAnimationFrame(l)},requestAnimationFrame(l))};pageScroll=function(e){fakeScrollbar.classList.toggle("active",e),body.classList.toggle("no-scroll",e),body.style.paddingRight=e?fakeScrollbar.offsetWidth-fakeScrollbar.clientWidth+"px":""},sticky=function(e,t,o){e="string"==typeof e?q(e):e,o=o||"fixed",t=t||"bottom";var n=e.getBoundingClientRect()[t]+pageYOffset,r=e.cloneNode(!0),i=e.parentElement,l=function(){!e.classList.contains(o)&&pageYOffset>=n&&(i.appendChild(i.replaceChild(r,e)),e.classList.add(o),window.removeEventListener("scroll",l),window.addEventListener("scroll",a))},a=function(){e.classList.contains(o)&&pageYOffset<=n&&(i.replaceChild(e,r),e.classList.remove(o),window.removeEventListener("scroll",a),window.addEventListener("scroll",l))};r.classList.add("clone"),l(),window.addEventListener("scroll",l)},window.addEventListener("load",function(){wp.blocks.registerBlockStyle("core/media-text",{name:"without-grid-left",label:"Без сетки слева"}),wp.blocks.registerBlockStyle("core/media-text",{name:"without-grid-right",label:"Без сетки справа"}),wp.blocks.registerBlockStyle("core/media-text",{name:"without-grid",label:"Без сетки"})});