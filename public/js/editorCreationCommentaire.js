document.getElementById("mouseCategories").addEventListener("mouseover", myFunctionIn);
document.getElementById("mouseCategories").addEventListener("mouseout", myFunctionOut);
document.getElementById("mouseCategories").addEventListener("click", myFunction);

function myFunctionIn() {
  var x = document.getElementById("categories");
    x.style.display = "block";
}

function myFunctionOut() {
  var x = document.getElementById("categories");
    x.style.display = "none";
}

function myFunction() {
  var x = document.getElementById("categories");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}



CKFinder.config( { connectorPath: '/ckfinder/connector' } );
var editorC = CKEDITOR.replace('comment[content]',
{
    type: 'textarea',
    toolbarLocation : 'top',
    language: 'fr',
    uiColor: '#FFFFFF',
    height: '100px',
    colorButton_enableAutomatic : false,
    toolbar: [
      { name: 'insert', items: [ 'Image','HorizontalRule','Smiley', 'SpecialChar'] },
      { name: 'clipboard', items: [ 'Undo', 'Redo' ] },
      { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
      { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
      { name: 'colors', items: [ 'TextColor'] },
      { name: 'align', items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
      { name: 'links', items: [ 'Link', 'Unlink' ] }
       ],
       removeDialogTabs: 'image:advanced;link:advanced',

      height: 150

});
CKFinder.setupCKEditor(editorC);

editorC.on( 'required', function( evt ) {
    alert( 'Un commentaire ne peut pas être soumis vide !!!' );
    console.log(evt);
    evt.cancel();
} );
editorC.on( 'disabled', function( evt ) {
    alert( 'Connectez-vous pour écrire un commentaire' );
    console.log(evt);
    evt.cancel();
} );

/*{ name: 'insert', items: [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] }
      { name: 'document', items: [ 'Print' ] },
      { name: 'clipboard', items: [ 'Undo', 'Redo' ] },
      { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
      { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'CopyFormatting' ] },
      { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
      { name: 'align', items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
      { name: 'links', items: [ 'Link', 'Unlink' ] },
      { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
      { name: 'tools', items: [ 'Maximize', 'ShowBlocks','-','About' ] },
      { name: 'editing', items: [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] }
*/
