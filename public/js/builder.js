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
            "content":"TitleView Description"
        });
        this.addControl("textview");
    },

    addTextBox: function () {
        window.formObject.elementIndex = window.formObject.elementIndex+1;
        window.formObject.elements.push({
            "id":window.formObject.elementIndex,
            "type":"textbox",
            "name":"Title2",
            "content":"textboxcontent"
        });
        this.addControl("textbox");
    },

    addCheckBox : function () {
        window.formObject.elementIndex = window.formObject.elementIndex+1;
        window.formObject.elements.push({
            "id" : window.formObject.elementIndex,
            "type" : "checkbox",
            "name" : "Title3",
            "options": ["checkbox_content1", "checkbox_content2"]
        });
        this.addControl("checkbox");
    },

    addControl : function (type) {
        var html = $("#nodes ."+type).clone()[0].innerHTML;
        html = "<div id='" + window.formObject.elementIndex + "' class='" + type + "'>" +
            html +
            "<div class='handle' style='position:absolute;top:0;left:0;width:100%;height:100%;'" +
            "</div>"
        $(html).appendTo($("#formcontent"));
        formFunc.refresh();

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
                window.editingObject = elements[index];
                eval(type+".initialize()");
                $("#editingContent ."+type).show();
            }
        })
    },

    refresh : function(){
        $("#formname").text(formObject.name);
        var elements = formObject.elements;
        for(var i=0; i<elements.length; i++){
            var id = elements[i].id;

            if(elements[i]["name"]){
                $("#" + id + " p[node='nameView']").text(elements[i]["name"])
                $("#" + id + " input[node='name']").attr("name", elements[i]["name"]);
            }
            if(elements[i]["content"]){
                $("#" + id + " p[node='contentView']").text(elements[i]["content"]);
            }
        }
    }
};


$().ready(function(){
    window.formObject._token = window.Laravel.csrfToken;
    formFunc.refresh();

    $("#formname").click(function () {
        $("#editingContent > div").hide();
        window.editingObject = window.formObject;
        window.formName.initialize();
        $("#editingContent > .formname").show();
    });

    $("#submitForm").click(function(){
        $.post("/learnlaravel/public/worldbuilder/build", window.formObject);
    });

    $("#confirmEditing").click(function () {
        node = $(this).attr("node");
        eval(node+".confirm()");
    });

    $("#addTextBox").click(function () {
        formFunc.addTextBox();
    });

    $("#addCheckBox").click(function () {
        formFunc.addCheckBox();
    });

    $("#addTextView").click(function () {
        formFunc.addTextView();
    })

});

//editing functions
$().ready(function () {
    // // editing
    // $("#editing input[node='name']" ).change(function () {
    //     nameValue = $(this).val();
    //     window.editingObject["name"] = nameValue;
    //     id = window.editingObject.id;
    //     if(window.editingObject === window.formObject){
    //         $("#formname").text(nameValue);
    //     }else {
    //         $("#" + id + " p[node='nameView']").text(nameValue)
    //         $("#" + id + " input[node='name']").attr("name", nameValue);
    //     }
    // });
    // $("#editing input[node='content']").change(function () {
    //     nameValue = $(this).val();
    //     window.editingObject["content"] = nameValue;
    //     id = window.editingObject.id;
    //     $("#" + id + " p[node='contentView']").text(nameValue);
    // })

});





