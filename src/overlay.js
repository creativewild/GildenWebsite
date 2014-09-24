function report(c_id) {
    var form = document.createElement("form", "report_form");
    form.id = "report_form";
    form.method = "post";
    form.action = "./2_Pictures.php?mode=post_comment";
 
    var reply_place = document.createElement("div");
    reply_place.id = "overlay";
    var inner_div = document.createElement("div"), button_close = document.createElement("button");
    button_close.id = "upprev_close";
    button_close.innerHTML = "x";
    button_close.onclick = function () {
        var element = document.getElementById('overlay');
        element.parentNode.removeChild(element);
    };
    inner_div.appendChild(button_close);
 
    var legend = document.createElement("legend");
    legend.innerHTML = "Why do you want to report this?";
    form.appendChild(legend);

    var input1 = document.createElement("input");
    input1.type = "button";
    input1.id = "nudity";
    input1.value = "nudity";
    input1.name = "options";
    var radio_label1 = document.createElement("label");
    radio_label1.htmlFor = "nudity";
    radio_label1_text = "Nudity";
    radio_label1.appendChild(document.createTextNode(radio_label1_text));
    form.appendChild(input1);
    form.appendChild(radio_label1);
 
    var input2 = document.createElement("input");
    input2.type = "radio";
    input2.id = "attacks";
    input2.value = "attacks";
    input2.name = "options";
    var radio_label2 = document.createElement("label");
    radio_label2.htmlFor = "attacks";
    radio_label2_text = "Personal attack";
    radio_label2.appendChild(document.createTextNode(radio_label2_text));
    form.appendChild(input2);
    form.appendChild(radio_label2);
 
    var input3 = document.createElement("input");
    input3.type = "radio";
    input3.id = "spam";
    input3.value = "spam";
    input3.name = "options";
    var radio_label3 = document.createElement("label");
    radio_label3.htmlFor = "spam";
    radio_label6_text = "Spam";
    radio_label3.appendChild(document.createTextNode(radio_label6_text));
    form.appendChild(input3);
    form.appendChild(radio_label3);
 
    var submit_btn = document.createElement("input", "the_submit");
    submit_btn.type = "submit";
    submit_btn.className = "submit";
    submit_btn.value = "Report";
    form.appendChild(submit_btn);
 
    submit_btn.onclick = function () {
        var checked = false, formElems = this.parentNode.getElementsByTagName('input');
        for (var i = 0; i < formElems.length; i++) {
            if (formElems[i].type == 'radio' && formElems[i].checked == true) {
                checked = true;
                var el = formElems[i];
                break;
            }
        }
        if (!checked) return false;
        var poststr = "c_id=" + c_id + "&reason=" + encodeURI(el.value);
        alert(poststr);
        return false;
    }
 
    inner_div.appendChild(form);
    reply_place.appendChild(inner_div);
 
    var attach_to = document.getElementById("wrapper"), parentDiv = attach_to.parentNode;
    parentDiv.insertBefore(reply_place, attach_to);

}