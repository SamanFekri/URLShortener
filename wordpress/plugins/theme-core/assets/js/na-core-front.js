!function(a){"use strict";function b(){a(".nano-custom-attribute > li").live("click",function(b){b.preventDefault();var c=a(this).data("value"),d=a(this).parent().data("attribute"),e=a("select#"+d);a(this).addClass("selected").siblings().removeClass("selected"),e.val(c).trigger("change")}),a(".variations_form").live("change","select[data-attribute_name]",function(){setTimeout(function(){a(".variations_form select[data-attribute_name]").each(function(b,c){""==a(c).val()&&1==a(c).children('[value!=""]').length&&a(c).val(a(c).children('[value!=""]').attr("value")).trigger("change")})},50),a(".nano-custom-attribute[data-attribute]").each(function(b,c){!function(b){setTimeout(function(){var c=a(b).attr("data-attribute"),d=a("#"+c);a(b).children().each(function(b,c){1==d.children('[value="'+a(c).attr("data-value")+'"]').length?a(c).show():a(c).hide()})},50)}(c)})}),a("a.reset_variations").live("click",function(){a(".nano-custom-attribute").each(function(b,c){a(c).find("li.selected").removeClass("selected")})})}a(document).ready(function(){b()})}(jQuery);