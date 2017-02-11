/**
 * Created by cano on 2017/2/4.
 */


var formObject =  {
    elementIndex : 0,
    name : "FormName",
    elements : [],
    _token : ""
};

var formFunc = {
    addTextView : function () {
        window.formObject.elementIndex = window.formObject.elementIndex + 1;
        window.formObject.elements.push({
           "id":window.formObject.elementIndex,
           "type":"textview",
            "content":"textviewcontent"
        });
    },

    addTextBox: function () {
        window.formObject.elementIndex = window.formObject.elementIndex+1;
        window.formObject.elements.push({
            "id":window.formObject.elementIndex,
            "type":"textbox",
            "name":"textboxname",
            "content":"textboxcontent"
        });
    },

    addCheckBox : function () {
        window.formObject.elementIndex = window.formObject.elementIndex+1;
        window.formObject.elements.push({
            "id" : window.formObject.elementIndex,
            "type" : "checkbox",
            "name" : "checkboxname",
            "elements": ["checkbox_content1", "checkbox_content2"]
        });
    },

    addControl : function (type) {
        var html = $("#nodes ."+type).clone()[0].innerHTML;
        html = "<div id='" + window.formObject.elementIndex + "' class='" + type + "'>" +
            html +
            "<div class='handle' style='position:absolute;top:0;left:0;width:100%;height:100%;'" +
            "</div>"
        $(html).appendTo($("#formcontent"));

        $(".handle").click(function () {
            var type = $(this).parent().attr("class");
            var id = $(this).parent().attr("id");

            $("#editingContent > div").hide();

            var index = -1;
            var elements = window.formObject.elements;
            for(var i=0; i<elements.length; i++){
                if(elements[i].id == id){
                    index = i;
                    break;
                }
            }
            if(index >= 0){
                formFunc.fill(type, elements[index]);
                window.editingObject = elements[index];
                $("#editingContent ."+type).show();
            }
        })
    },

    fill : function (type, element) {
        if(element["name"]){
            $("input[node='name']").val(element["name"]);
        }
        if(element["content"]){
            $("input[node='content']").val(element["content"]);
        }
    }

};


$().ready(function(){
    window.formObject._token = window.Laravel.csrfToken;
    $("#formname").click(function () {
        $("#editingContent > div").hide();
        formFunc.fill("formname", window.formObject);
        window.editingObject = window.formObject;
        $("#editingContent > .formname").show();
    });

    $("#submitForm").click(function(){
        $.post("/learnlaravel/public/worldbuilder/build", window.formObject);
    });

    $("#addTextBox").click(function () {
        formFunc.addTextBox();
        formFunc.addControl("textbox");
    });

    $("#addCheckBox").click(function () {
        formFunc.addCheckBox();
        formFunc.addControl("checkbox");
    });

    $("#addTextView").click(function () {
        formFunc.addTextView();
        formFunc.addControl("textview");
    })

});

$().ready(function () {
    // editing
    $("input[node='name']" ).change(function () {
        window.editingObject["name"] = $(this).val();
    });
    $("input[node='content'").change(function () {
        window.editingObject["content"] = $(this).val();
    })

});





