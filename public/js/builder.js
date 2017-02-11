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
        this.addControl({
           "id":window.formObject.elementIndex,
           "type":"textview",
            "content":"TitleView Description"
        });
    },

    addTextBox: function () {
        this.addControl({
            "id":window.formObject.elementIndex,
            "type":"textbox",
            "name":"Title2",
            "content":"textboxcontent"
        });
    },

    addCheckBox : function () {
        this.addControl({
            "id" : formObject.elementIndex,
            "type" : "checkbox",
            "name" : "Title3",
            "options": ["checkbox_content1", "checkbox_content2"]
        });
    },

    addControl: function (obj) {
        formObject.elementIndex = formObject.elementIndex+1;
        formObject.elements.push(obj);
        this.refresh();
    },

    refresh : function(){
        $("#formname").text(formObject.name);
        this.buildForm();

        $("<div class='handle' style='position:absolute;top:0;left:0;width:100%;height:100%;'></div>").appendTo($("#formcontent>div"));
        $(".handle").click(function () {
            var id = $(this).parent().attr("id");
            if(id>=0 && id<formObject.elements.length){
                editingObject = formObject.elements[id];
                type = editingObject["type"];
                eval(type+"editing.initialize()");
                $("#editingContent > div").hide();
                $("#"+type+"E").show();
            }
        })
    },

    buildForm: function () {
        $("#formcontent").children().remove();
        var elements = formObject.elements;
        for(var i=0; i<elements.length; i++){
            var id = elements[i].id;
            var type = elements[i].type;
            eval(type+".generateNode(elements[i],$('#formcontent'))");
        }
    }
};


$().ready(function(){
    window.formObject._token = window.Laravel.csrfToken;

    $("#formname").click(function () {
        $("#editingContent > div").hide();
        window.editingObject = window.formObject;
        window.formnameediting.initialize();
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





