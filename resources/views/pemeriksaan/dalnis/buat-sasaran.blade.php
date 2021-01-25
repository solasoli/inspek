@extends('layouts.app')
@section('content')
<div class="br-mainpanel" id="panel-0">
    <div class="br-pagetitle">
      <div><br>
        <h4>Buat Sasaran Kerja</h4>
      </div>
    </div>

    <div class="br-pagebody">


      <div class="row row-sm mg-t-20" style="margin-bottom: 40px">
        <div class="col-lg-12 widget-2 px-0">
          <div class="card shadow-base">

            <input type="hidden" name="count" value="1" />


            <div class="card-header">
              <p><input id="more_info8" name="more-info" type="checkbox" />
               <span id="data1">Dasar Pemeriksaan Tujuan Tertentu</span></p>
             </div>
            <div id="conditional_part8" style="display: none;">
              <table class="table">
                <tr>
                  <td><textarea name="editor1" id="editor1" rows="10" cols="80"></textarea></td>
                </tr>
                
              </table>
              
            </div>
            

            <div class="card-header">
              <p><input id="more_info2" name="more-info" type="checkbox" />
               <span id="data1">Ruang Lingkup</span></p>
             </div>
             <div id="conditional_part2">
              <table class="table">
               
                <tr>
                  <td><textarea name="editor3" id="editor3" rows="10" cols="80"></textarea></td>
                </tr>
                
              </table>
              
            </div>

            <div class="card-header">
              <p><input id="more_info3" name="more-info" type="checkbox" />
               <span id="data1">Tujuan Pemeriksaan</span></p>
             </div>
             <div id="conditional_part3">
              <table class="table">

                <tr>
                  <td><textarea name="editor4" id="editor4" rows="10" cols="80"></textarea></td>
                </tr>
                
                
              </table>
              
            </div>

            <div class="card-header">
              <p><input id="more_info4" name="more-info" type="checkbox" />
               <span id="data1">Metodologi Pemeriksaan</span></p>
             </div>

             <div id="conditional_part4">
              <table class="table">
                <tr>
                  <td><textarea name="editor5" id="editor5" rows="10" cols="80"></textarea></td>
                </tr>
                
              </table>
              
            </div>

            <div class="card-header">
              <p><input id="more_info5" name="more-info" type="checkbox" />
               <span id="data1">Tahapan Pemeriksaan</span></p>
             </div>

             <div id="conditional_part5">
              <table class="table">
                <tr>
                  <td><textarea name="editor6" id="editor6" rows="10" cols="80"></textarea></td>
                </tr>
                
              </table>
              
            </div>

            <div class="controls" id="profs">
              <div class="form-group">
                <label for="data" class="w-100">
                  <div class="card-header" style="display: none;"><p><input id="more_info6" name="more-info" type="checkbox" /> <input type="text" id="data1" name=""></label></p></div>
                    <input autocomplete="off" class="form-control" style="display: none;" id="field1" name="prof1" type="text" placeholder="" data-provide="typeahead" data-items="8" /><br>
                    <button id="b1" style="margin-left: 13px;width: 200px;" class="btn btn-success add-more" type="button">+ Tambah Poin</button>
                    <hr>
                    <center><button class="btn btn-info" style="width:30%">SAVE AS DRAFT</button>&nbsp;<button class="btn btn-primary" style="width:30%">SIMPAN</button></center>  
                </div>
                
              </div>
              

            </div>
          </div>
        </div>
      </div>


    </div><!-- br-pagebody -->
    
    <script type="text/javascript">
        $(document).ready(function(){
       var next = 1;
       $(".add-more").click(function(e){
           e.preventDefault();
           var addto = "#field" + next;
           var addRemove = "#field" + (next);
           next = next + 1;
           var newIn = '<br /><label for="data" class="w-100"><div class="card-header" id="field' + next + '" name="field' + next + '"><p><input id="more_info5" name="more-info" type="checkbox" /> <input type="text" id="data1" name=""></label></p></div><input style="display:none" autocomplete="off" class="form-control" id="field' + next + '" name="field' + next + '" type="text" data-provide="typeahead" data-items="8">';
           var newInput = $(newIn);
           var removeBtn = '<button id="remove' + (next - 0) + '" class="btn btn-danger remove-me" style="margin:10px; margin-bottom:0px" >Hapus</button>';
	         var removeButton = $(removeBtn);
           $(addto).after(newInput);
           $(addRemove).after(removeButton);
           $("#field" + next).attr('data-source',$(addto).attr('data-source'));
           $("#count").val(next);  
           
         

          $('body').on("click", ".remove-me", function(e){
            e.preventDefault();
            var fieldNum = this.id.charAt(this.id.length-1);
            var fieldID = "#field" + fieldNum;
            $(this).remove();
            $(fieldID).remove();
            
          });

       });
   }); 
   
       </script>
       <script>
         $(function(){
           'use strict'
   
           // FOR DEMO ONLY
           // menu collapsed by default during first page load or refresh with screen
           // having a size between 992px and 1299px. This is intended on this page only
           // for better viewing of widgets demo.
           $(window).resize(function(){
             minimizeMenu();
           });
   
           minimizeMenu();
   
           function minimizeMenu() {
             if(window.matchMedia('(min-width: 992px)').matches && window.matchMedia('(max-width: 1299px)').matches) {
               // show only the icons and hide left menu label by default
               $('.menu-item-label,.menu-item-arrow').addClass('op-lg-0-force d-lg-none');
               $('body').addClass('collapsed-menu');
               $('.show-sub + .br-menu-sub').slideUp();
             } else if(window.matchMedia('(min-width: 1300px)').matches && !$('body').hasClass('collapsed-menu')) {
               $('.menu-item-label,.menu-item-arrow').removeClass('op-lg-0-force d-lg-none');
               $('body').removeClass('collapsed-menu');
               $('.show-sub + .br-menu-sub').slideDown();
             }
           }
         });
       </script>
        <script>
           ClassicEditor
               .create( document.querySelector( '#editor' ) )
               .catch( error => {
                   console.error( error );
               } );
       </script>
     <script>
           ClassicEditor
               .create( document.querySelector( '#editor2' ) )
               .catch( error => {
                   console.error( error );
               } );
       </script>
       <script>
           ClassicEditor
               .create( document.querySelector( '#editor3' ) )
               .catch( error => {
                   console.error( error );
               } );
       </script>
       <script>
           ClassicEditor
               .create( document.querySelector( '#editor4' ) )
               .catch( error => {
                   console.error( error );
               } );
       </script>
       <script>
           ClassicEditor
               .create( document.querySelector( '#editor5' ) )
               .catch( error => {
                   console.error( error );
               } );
       </script>
        <script>
           ClassicEditor
               .create( document.querySelector( '#editor6' ) )
               .catch( error => {
                   console.error( error );
               } );
       </script>
       <script>
           ClassicEditor
               .create( document.querySelector( '#editor8' ) )
               .catch( error => {
                   console.error( error );
               } );
       </script>
       <script type="text/javascript">
  // Añade el CK Editor
CKEDITOR.editorConfig = function (config) {
    config.language = 'es';
    config.uiColor = '#F7B42C';
    config.height = 300;
    config.toolbarCanCollapse = true;
  };
  CKEDITOR.replace('editor1');
  CKEDITOR.replace('editor2');
  CKEDITOR.replace('editor3');
  CKEDITOR.replace('editor4');
  CKEDITOR.replace('editor5');
  CKEDITOR.replace('editor6');

// ANADE IMG ON CLICK
var brandImg = document.querySelectorAll("#brand-img img");

for (var i = 0; i < brandImg.length; i++) {
    ckEdiloop = brandImg[i];
    ckEdiloop.addEventListener("click", function(el){
        ckEdImg = '<p><img src="'+this.src+'" /></p>'; // La forma como las imágenes son envueltas en ckEditor
        CKEDITOR.instances['editor1'].insertHtml(ckEdImg) // Añade img al editor
    });
}
</script>

   
       <script type="text/javascript">
         $('#more_info').change(function() {
           if(this.checked != true){
             $("#conditional_part").hide();
           }
           else{
             $("#conditional_part").show();
           }
         });
   
         $('#more_info2').change(function() {
           if(this.checked != true){
             $("#conditional_part2").hide();
           }
           else{
             $("#conditional_part2").show();
           }
         });
   
         $('#more_info3').change(function() {
           if(this.checked != true){
             $("#conditional_part3").hide();
           }
           else{
             $("#conditional_part3").show();
           }
         });
   
         $('#more_info4').change(function() {
           if(this.checked != true){
             $("#conditional_part4").hide();
           }
           else{
             $("#conditional_part4").show();
           }
         });
   
         $('#more_info5').change(function() {
           if(this.checked != true){
             $("#conditional_part5").hide();
           }
           else{
             $("#conditional_part5").show();
           }
         });
         $('#more_info6').change(function() {
           if(this.checked != true){
             $("#conditional_part6").hide();
           }
           else{
             $("#conditional_part6").show();
           }
         });
         $('#more_info7').change(function() {
           if(this.checked != true){
             $("#conditional_part7").hide();
           }
           else{
             $("#conditional_part7").show();
           }
         });
         $('#more_info8').change(function() {
           if(this.checked != true){
             $("#conditional_part8").hide();
           }
           else{
             $("#conditional_part8").show();
           }
         });
       </script>
   
@endsection