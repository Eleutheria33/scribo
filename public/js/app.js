var video = document.getElementById("myVideo");
var btn = document.getElementById("myBtn");

function myFunction() {
  if (video.paused) {
    video.play();
    btn.innerHTML = "Pause";
  } else {
    video.pause();
    btn.innerHTML = "Play";
  }
}

/* gestion navbar hiden in scrolldown visible in scrollup*/

var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
var currentScrollPos = window.pageYOffset;
  navTools = document.getElementById("navbar");
  if (prevScrollpos > currentScrollPos) {
    navTools.style.top = "0";
  } else {
    navTools.style.top = "-"+navTools.clientHeight+"px";
  }
  prevScrollpos = currentScrollPos;
}

/* footer */

function openNav() {
  document.getElementById("myFooterPanel").style.borderTopRightRadius = "0px";
  document.getElementById("myFooterPanel").style.borderBottomRightRadius = "0px";
  document.getElementById("myFooterPanel").style.width = "100%";
  document.getElementById("myFooterPanel").style.height = "auto";
  document.getElementById("myFooterPanel").style.bottom = "0";
  document.getElementById("myFooterPanel").style.background = "#111";
  document.getElementById("myFooterPanel").style.left = "0";
  document.getElementById("openbtn").style.display = "none";

}
function closeNav() {
  document.getElementById("myFooterPanel").style.borderTopRightRadius = "350px";
  document.getElementById("myFooterPanel").style.borderBottomRightRadius = "350px";
  document.getElementById("myFooterPanel").style.width = "0";
  document.getElementById("myFooterPanel").style.background = "#f1f1f1";
  document.getElementById("myFooterPanel").style.left = "-1000px";
  document.getElementById("openbtn").style.display = "block";

}


/* slider page home*/

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}
var slidesHeight = document.querySelector(".contain").clientHeight;
var galleryHeight = document.querySelector(".gallery");
    galleryHeight.style.height = slidesHeight+"px" ;
    galleryHeight.style.overflow = "scroll" ;

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");

  var dots = document.getElementsByClassName("demo");
  var dataHidden = document.getElementsByClassName("data-hidden");
  var articleContent = document.getElementById("content");

  var captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  heightImgText = slides[slideIndex-1].clientHeight;
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
  articleContent.innerHTML = dataHidden[slideIndex-1].innerHTML;
  articleContent.style.height = heightImgText+"px" ;

}

function deleteFlash() {
  if($('#flashArea').hasClass('flash-systeme')){

        $('#flashArea').css('display','none');

  }
}


/*tinymce.init({
  selector: 'textarea',

});*/

/*tinymce.init({
  selector:'textarea',
  max_height: 600,
  max_width: 500,
  min_height: 200,
  min_width: 400,
  images_upload_url: 'postAcceptor.php',
  automatic_uploads: false

   });
*/
/*tinymce.init({
  selector: 'textarea',
  plugins: 'image media link tinydrive code imagetools',
  api_key: 'kaxd8m5pl9eq5vsztjt281440by9omj60q01jzdmxhkpe9qc',
  height: 600,
  tinydrive_max_image_dimension: 300,
  tinydrive_upload_path: '../images',
  tinydrive_token_provider: 'URL_TO_YOUR_TOKEN_PROVIDER',
  toolbar: 'insertfile image link | code'
});*/




/* document.getElementById("butSubmit").addEventListener("click", function() {
        editor.updateSourceElement();
    });
*/
/*class MyUploadAdapter {
    constructor( loader ) {
        // The file loader instance to use during the upload.
        this.loader = loader;
    }

    // Starts the upload process.
    upload() {
        return new Promise( ( resolve, reject ) => {
            this._initRequest();
            this._initListeners( resolve, reject );
            this._sendRequest();
        } );
    }

    // Aborts the upload process.
    abort() {
        if ( this.xhr ) {
            this.xhr.abort();
        }
    }

    // Initializes the XMLHttpRequest object using the URL passed to the constructor.
    _initRequest() {
        const xhr = this.xhr = new XMLHttpRequest();

        // Note that your request may look different. It is up to you and your editor
        // integration to choose the right communication channel. This example uses
        // a POST request with JSON as a data structure but your configuration
        // could be different.
        //xhr.open( 'POST', 'http://example.com/image/upload/path', true );http://localhost:8000/article/create
        xhr.open( 'POST', 'http://localhost:8000/public/images', true );
        xhr.responseType = 'json';
    }

    // Initializes XMLHttpRequest listeners.
    _initListeners( resolve, reject ) {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = 'Couldn\'t upload file:' + ` ${ loader.file.name }.`;

        xhr.addEventListener( 'error', () => reject( genericErrorText ) );
        xhr.addEventListener( 'abort', () => reject() );
        xhr.addEventListener( 'load', () => {
            const response = xhr.response;

            // This example assumes the XHR server's "response" object will come with
            // an "error" which has its own "message" that can be passed to reject()
            // in the upload promise.
            //
            // Your integration may handle upload errors in a different way so make sure
            // it is done properly. The reject() function must be called when the upload fails.
            if ( !response || response.error ) {
                return reject( response && response.error ? response.error.message : genericErrorText );
            }

            // If the upload is successful, resolve the upload promise with an object containing
            // at least the "default" URL, pointing to the image on the server.
            // This URL will be used to display the image in the content. Learn more in the
            // UploadAdapter#upload documentation.
            resolve( {
                default: response.url
            } );
        } );

        // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
        // properties which are used e.g. to display the upload progress bar in the editor
        // user interface.
        if ( xhr.upload ) {
            xhr.upload.addEventListener( 'progress', evt => {
                if ( evt.lengthComputable ) {
                    loader.uploadTotal = evt.total;
                    loader.uploaded = evt.loaded;
                }
            } );
        }
    }

    // Prepares the data and sends the request.
    _sendRequest() {
        // Prepare the form data.
        const data = new FormData();
        data.append( 'upload', this.loader.file );

        // Important note: This is the right place to implement security mechanisms
        // like authentication and CSRF protection. For instance, you can use
        // XMLHttpRequest.setRequestHeader() to set the request headers containing
        // the CSRF token generated earlier by your application.

        // Send the request.
        this.xhr.send( data );
    }
}

// ...

function MyCustomUploadAdapterPlugin( editor ) {
    editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
        // Configure the URL to the upload script in your back-end here!
        return new MyUploadAdapter( loader );
    };
}*/

/*ClassicEditor.create(document.querySelector('.editor'), {
              /*cloudServices: {
                  tokenUrl: 'https://example.com/cs-token-endpoint',
                  uploadUrl: 'https://your-organization-id.cke-cs.com/easyimage/upload/'
              }*/
              /*extraPlugins: [ MyCustomUploadAdapterPlugin ]*/
              /*ckfinder: {
                uploadUrl: 'https://example.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json'
              }
              })
              .then( newEditor => {
                  editor = newEditor;
              } )
             .catch(error => {
                console.error(error);
             });*/
// ...*/

/*ClassicEditor
    .create( document.querySelector( '#editor' ), {
        extraPlugins: [ MyCustomUploadAdapterPlugin ],

        // ...
    } )
    .catch( error => {
        console.log( error );
    } );
*/



        /*$(function() {
            $('textarea.ckeditor').ckeditor();
        });
*/



















 /*ClassicEditor
    .create( document.querySelector( '.editor' ), {
        plugins: [
            Autosave,

            // ... other plugins
        ],

        autosave: {
            save( editor ) {
                return saveData( editor.getData() );
            }
        }
    } )
    .then( editor => {
        window.editor = editor;

        displayStatus( editor );
    } )
    .catch( err => {
        console.error( err.stack );
    } );

// Save the data to a fake HTTP server (emulated here with a setTimeout()).
function saveData( data ) {
    return new Promise( resolve => {
        setTimeout( () => {
            console.log( 'Saved', data );

            resolve();
        }, HTTP_SERVER_LAG );
    } );
}

// Update the "Status: Saving..." info.
function displayStatus( editor ) {
    const pendingActions = editor.plugins.get( 'PendingActions' );
    const statusIndicator = document.querySelector( '#editor-status' );

    pendingActions.on( 'change:hasAny', ( evt, propertyName, newValue ) => {
        if ( newValue ) {
            statusIndicator.classList.add( 'busy' );
        } else {
            statusIndicator.classList.remove( 'busy' );
        }
    } );
}*/
/*document.getElementById("butSubmit").addEventListener("click", function() {
       var content = CKEDITOR.instances.editor.getData();
       console.log(content);
    });*/



/*,
                {
                toolbar: [ 'heading', '|', 'bold', 'italic', 'link',
                 'bulletedList', 'numberedList', 'blockQuote','image','smiley','specialChar',
                 'print', 'underline', 'justifyLeft', 'justifyCenter', 'justifyRight', 'justifyBlock',
                 'undo', 'redo', 'numberedList', 'bulletedList'
                  ]
               }*/
/*{


    toolbar: [
                { name: 'insert', items: [ 'Image','Smiley','SpecialChar' ] },
                { name: 'document', items: [ 'Print' ] },
                { name: 'clipboard', items: [ 'Undo', 'Redo' ] },
                { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline' ] },
                { name: 'align', items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
                { name: 'links', items: [ 'Link' ] },
                { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', 'Blockquote' ] },
                { name: 'tools', items: [ 'Maximize' ] },
                { name: 'styles', items: [ 'Format', 'FontSize' ] }
       ]

}
*/
