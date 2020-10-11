@extends('layouts.app')
@section('content')
<div class="br-mainpanel" id="panel-0">
    <div class="br-pagetitle">
      <div><br>
        <h4>Buat Program Kerja</h4>
      </div>
    </div>

    <div class="br-pagebody">


<div class="row row-sm mg-t-20" style="margin-bottom: 40px">
  <div class="col-lg-12 widget-2 px-0">
    <div class="card shadow-base">

      <input type="hidden" name="count" value="1" />
      <div class="card-header">
        <p><input id="more_info6" name="more-info" type="checkbox" />
         <span id="data1">Judul</span></p>
       </div>

       <div id="conditional_part6" style="display: none;">
        <div id="editor6" rows="5"><br></div>
        
      </div>

      
      <div class="card-header">
        <p><input id="more_info2" name="more-info" type="checkbox" />
         <span id="data1">Pendahuluan</span></p>
       </div>
       <div id="conditional_part2">
        <div id="editor2" rows="5"></div>
      </div>

      <div class="card-header">
        <p><input id="more_info3" name="more-info" type="checkbox" />
         <span id="data1">Tujuan Pemeriksaan</span></p>
       </div>
       <div id="conditional_part3">
          <div id="editor3" rows="5"><br></div>
       </div>

      <div class="card-header">
        <p><input id="more_info4" name="more-info" type="checkbox" />
         <span id="data1">Ruang Lingkup Pemeriksaan</span></p>
       </div>

       <div id="conditional_part4">
        <div id="editor4" rows="5"><br></div>
        
      </div>

      <div class="card-header">
        <p><input id="more_info5" name="more-info" type="checkbox" />
         <span id="data1">Waktu Pelaksanaan</span></p>
       </div>

       <div id="conditional_part5">
        <div id="editor5" rows="5"><br></div>
        
      </div>
      <div class="card-header">
        <p><input id="more_info" name="more-info" type="checkbox" />
         <span id="data1">Langkah Kerja Pemeriksaan Rinci</span></p>
       </div>
       <div id="conditional_part">
        <!-- <div class="tag-tree">
          <ul id="addParent">
            <li class="root" class="add-child">
              <input style="height: 30px;margin-top:4px;padding: 6px 12px;font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;" /> <p class="add-child-field"><i class="fa fa-plus" style="font-size: 20px"></i></p>
            </li>


          </ul>  
          <div class="add-field"><i class="fa fa-plus" style="font-size: 20px"></i> Tambah Menu</div>
        </div> -->

       <form action="">

      <div class="input-group control-group after-add-more">
        
        <table class="table table-borderless">
          <tr>
            <td width="15%"><h5 class="text-center">Judul Tugas</h5></td>
            <td width="50%"><input type="text" name="judul_tugas" class="form-control w-100" placeholder="Input Judul Tugas"></td>
            <td width="25%"></td>
          </tr>
          <tr>
            <td width="15%"><h5 class="text-center">Sub Judul Tugas</h5></td>
            <td width="65%"><input type="text" class="form-control w-100" name="addmore[]" placeholder="Sub Judul Tugas">
              
            <td width="20%"><div class="input-group-btn">
              <button class="btn btn-success add-more" type="button">
                <i class="glyphicon glyphicon-plus"></i> + Tambah
              </button>


            </div></td>
          </tr>
        </table>

        <hr>

       
      </div>
    </form>

      <div class="copy-fields hide" style="display: none;">
      <div class="control-group input-group" style="margin-top:-20px;">
        <table class="table table-borderless">
          <tr>
            <td width="15%"></td>
            <td width="65%"><input type="text" name="addmore[]" class="form-control w-100" placeholder=""></td>
            <td width="25%"><div class="input-group-btn">
              <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> X</button>
            </div>
          </td>
          </tr>
        </table>


      </div>
    </div>

    <div class="container">
      <table class="table table-borderless">
        <tr>
          <td width="15%"></td>
          <td width="65%"></td>
          <td width="25%"><label for="tambah" class="btn btn-info w-100">SIMPAN
            <input type="radio" id="tambah" name="chkPassPort" onclick="ShowHideDiv()" style="display: none;" />
          </label></td>
        </tr>
      </table>
    </div>


        <hr>

        <form action="">    
                 <div class="container" id="tambah_anak" onclick="ShowHideDiv()" style="display: none;">
                 <h4>A. KAK</h4>
                  <div class="input-group control-group after-add-more2">
                    
                    <table class="table table-borderless">
                      <tr>
                        <td width="15%"><h6 class="text-center">Tujuan Pemeriksaan</h6></td>
                        <td width="65%"><input type="text" name="judul_tugas" class="form-control w-100" placeholder="Tujuan Pemeriksaan"></td>
                        <td width="20%"></td>
                      </tr>
                      <tr>
                        <td width="15%"><h6 class="text-center">Prosedur Pemeriksaan</h6></td>
                        <td width="65%"><input type="text" class="form-control w-100" name="addmore2[]" placeholder="Prosedur Pemeriksaan">
                          
                          <td width="20%"><div class="input-group-btn">
                           <button class="btn btn-success add-more2" type="button">
                            <i class="glyphicon glyphicon-plus"></i> + Tambah
                          </button>
                        </div></td>
                      </tr>
                    </table>
                    
                    <div class="copy-fields2 hide" style="display: none;">
                      <div class="control-group input-group" style="margin-top:-20px;">
                        <table class="table table-borderless">
                          <tr>
                            <td width="15%"></td>
                            <td width="65%"><input type="text" name="addmore2[]" class="form-control w-100" placeholder=""></td>
                            <td width="20%"><div class="input-group-btn">
                              <button class="btn btn-danger removes" type="button">X</button>
                            </div>
                          </td>
                        </tr>
                      </table>


                    </div>
                  </div>
                </div>
                


                <hr style="font-size: 10px solid">
                <div class="row">
                  <div class="col-md-6">
                    <h5 class="text-center">RENCANA</h5>
                    <table class="table table-borderless">
                      <tr>
                        <td width="25%">Pelaksana</td>
                        <td width="5">:</td>
                        <td width="70%"><select class="form-control"><option></option></select></td>
                      </tr>
                      <tr>
                        <td>Jam</td>
                        <td>:</td>
                        <td><select class="form-control"><option></option></select></td>
                      </tr>
                    </table>
                  </div>
                  <div class="col-md-6">
                    <h5 class="text-center">REALISASI</h5>
                    <table class="table table-borderless">
                      <tr>
                        <td width="25%">Pelaksana</td>
                        <td width="5">:</td>
                        <td width="70%"><select class="form-control"><option></option></select></td>
                      </tr>
                      <tr>
                        <td>Jam</td>
                        <td>:</td>
                        <td><select class="form-control"><option></option></select></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </form>


  <button class="btn btn-primary w-100">Simpan</button>
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
           var newIn = '<br /><label for="data" class="w-100"><div class="card-header" id="field' + next + '" name="field' + next + '"><p><input id="more_info5" name="more-info" type="checkbox" /> <input type="text" id="data1" name=""></label></p></div><input style="display:none" autocomplete="off" class="form-control w-100" id="field' + next + '" name="field' + next + '" type="text" data-provide="typeahead" data-items="8">';
           var newInput = $(newIn);
           var removeBtn = '<button id="remove' + (next - 0) + '" class="btn btn-danger remove-me" style="margin:10px; margin-bottom:0px" >Hapus</button>';
	         var removeButton = $(removeBtn);
           $(addto).after(newInput);
           $(addRemove).after(removeButton);
           $("#field" + next).attr('data-source',$(addto).attr('data-source'));
           $("#count").val(next);  
           
         
           $(document).ready(function(){
            var next = 1;
            $(".add-more2").click(function(e){
              e.preventDefault();
              var addto = "#field" + next;
              next = next + 1;
              var newIn = '<br /><div class="card-header"><p><input name="sub_judul" type="text" /> <input type="text" id="data1" name=""></label></p></div><input style="display:none" autocomplete="off" class="form-control" id="field' + next + '" name="field' + next + '" type="text" data-provide="typeahead" data-items="8">';
              var newInput = $(newIn);
              $(addto).after(newInput);
              $("#field" + next).attr('data-source',$(addto).attr('data-source'));
              $("#count").val(next);  
            });
          }); 

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

    
        <script type="text/javascript">
          $(document).ready(function() {
          //here first get the contents of the div with name class copy-fields and add it to after "after-add-more" div class.
          $(".add-more2").click(function() {
            var html = $(".copy-fields2").html();
            $(".after-add-more2").after(html);
          });
          //here it will remove the current value of the remove button which has been pressed
          $("body").on("click", ".removes", function() {
            $(this)
            .parents(".control-group")
            .remove();
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
  $(document).ready(function() {
  //here first get the contents of the div with name class copy-fields and add it to after "after-add-more" div class.
  $(".add-more").click(function() {
    var html = $(".copy-fields").html();
    $(".after-add-more").after(html);
  });
  //here it will remove the current value of the remove button which has been pressed
  $("body").on("click", ".remove", function() {
    $(this)
    .parents(".control-group")
    .remove();
  });
});

</script>

<script type="text/javascript">
  $(document).ready(function() {
  //here first get the contents of the div with name class copy-fields and add it to after "after-add-more" div class.
  $(".add-mores").click(function() {
    var html = $(".copy-fields").html();
    $(".after-add-mores").after(html);
  });
  //here it will remove the current value of the remove button which has been pressed
  $("body").on("click", ".removes", function() {
    $(this)
    .parents(".control-group")
    .remove();
  });
});

</script>

<script type="text/javascript">
     $(document).ready(function(){
    var next = 1;
    $(".add-more").click(function(e){
        e.preventDefault();
        var addto = "#field" + next;
        next = next + 1;
        var newIn = '<br /><div class="card-header"><p><input name="sub_judul" type="text" /> <input type="text" id="data1" name=""></label></p></div><input style="display:none" autocomplete="off" class="form-control" id="field' + next + '" name="field' + next + '" type="text" data-provide="typeahead" data-items="8">';
        var newInput = $(newIn);
        $(addto).after(newInput);
        $("#field" + next).attr('data-source',$(addto).attr('data-source'));
        $("#count").val(next);  
    });
}); 


    $(document).ready(function(){
    var next = 1;
    $(".add-mores").click(function(e){
        e.preventDefault();
        var addto = "#field" + next;
        next = next + 1;
        var newIn = '<br /><div class="card-header"><p><input name="sub_judul" type="text" /> <input type="text" id="data1" name=""></label></p></div><input style="display:none" autocomplete="off" class="form-control" id="field' + next + '" name="field' + next + '" type="text" data-provide="typeahead" data-items="8">';
        var newInput = $(newIn);
        $(addto).after(newInput);
        $("#field" + next).attr('data-source',$(addto).attr('data-source'));
        $("#count").val(next);  
    });
}); 

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

<script type="text/javascript">
    function ShowHideDiv() {

      var tambah = document.getElementById("tambah");
      var tambah_anak = document.getElementById("tambah_anak");
      tambah_anak.style.display = tambah.checked ? "block" : "none";

      var tambah2 = document.getElementById("tambah2");
      var tambah_anak2 = document.getElementById("tambah_anak2");
      tambah_anak2.style.display = tambah2.checked ? "block" : "none";

      var chkYes = document.getElementById("chkYes");
      var info = document.getElementById("info");
      info.style.display = chkYes.checked ? "block" : "none";

      var chkYess = document.getElementById("chkYess");
      var email = document.getElementById("email");
      email.style.display = chkYess.checked ? "block" : "none";

      var chkNoo = document.getElementById("chkNoo");
      var email2 = document.getElementById("email2");
      email2.style.display = chkNoo.checked ? "block" : "none";

      var yes = document.getElementById("yes");
      var validasi = document.getElementById("validasi");
      validasi.style.display = yes.checked ? "block" : "none";

      var no = document.getElementById("no");
      var validasi2 = document.getElementById("validasi2");
      validasi2.style.display = no.checked ? "block" : "none";

      
    }
   </script>
   
@endsection