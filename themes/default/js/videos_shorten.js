/*
 * jQuery Shorten plugin 1.1.0
 *
 * Copyright (c) 2014 Viral Patel
 * http://viralpatel.net
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 */

/*
** updated by Jeff Richardson
** Updated to use strict,
** IE 7 has a "bug" It is returning underfined when trying to reference string characters in this format
** content[i]. IE 7 allows content.charAt(i) This works fine in all modern browsers.
** I've also added brackets where they werent added just for readability (mostly for me).
*/
!function(e){e.fn.shorten=function(s){"use strict";var t={showChars:100,minHideChars:10,ellipsesText:"...",moreText:"more",lessText:"less",errMsg:null,force:!1};return s&&e.extend(t,s),e(this).data("jquery.shorten")&&!t.force?!1:(e(this).data("jquery.shorten",!0),e(document).off("click",".morelink"),e(document).on({click:function(){var s=e(this);return s.hasClass("less")?(s.removeClass("less"),s.html(t.moreText),s.parent().prev().animate({height:"0%"},function(){s.parent().prev().prev().show()}).hide("fast")):(s.addClass("less"),s.html(t.lessText),s.parent().prev().animate({height:"100%"},function(){s.parent().prev().prev().hide()}).show("fast")),!1}},".morelink"),this.each(function(){var s=e(this),r=s.html(),n=s.text().length;if(n>t.showChars+t.minHideChars){var a=r.substr(0,t.showChars);if(a.indexOf("<")>=0){for(var h=!1,i="",l=0,o=[],c=null,f=0,d=0;d<=t.showChars;f++)if("<"!=r[f]||h||(h=!0,c=r.substring(f+1,r.indexOf(">",f)),"/"==c[0]?c!="/"+o[0]?t.errMsg="ERROR en HTML: the top of the stack should be the tag that closes":o.shift():"br"!=c.toLowerCase()&&o.unshift(c)),h&&">"==r[f]&&(h=!1),h)i+=r.charAt(f);else if(d++,l<=t.showChars)i+=r.charAt(f),l++;else if(o.length>0){for(j=0;j<o.length;j++)i+="</"+o[j]+">";break}a=e("<div></div>").html(i+'<span class="ellip">'+t.ellipsesText+"</span>").html()}else a+=t.ellipsesText;var m='<div class="shortcontent">'+a+'</div><div class="allcontent">'+r+'</div><span><a href="javascript://nop/" class="morelink">'+t.moreText+"</a></span>";s.html(m),s.find(".allcontent").hide(),e(".shortcontent p:last",s).css("margin-bottom",0)}}))}}(jQuery);