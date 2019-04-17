CKFinder.config( { connectorPath: '/ckfinder/connector' } );
var editor = CKEDITOR.replace('article[content]',
{
    type: 'textarea',
    toolbarLocation : 'top',
    language: 'fr',
    uiColor: '#FFFFFF',
    height: '100px',
    colorButton_colors : 'CF5D4E,454545,FFF,CCC,DDD,CCEAEE,66AB16',
    colorButton_enableAutomatic : false,
    /*toolbar: [
      { name: 'insert ', items: [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe' ] },
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
       ],*/
       removeDialogTabs: 'image:advanced;link:advanced',

      height: 450

});
CKFinder.setupCKEditor(editor);
