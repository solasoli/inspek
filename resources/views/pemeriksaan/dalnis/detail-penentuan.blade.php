@extends('layouts.app')
@section('content')
<div class="br-mainpanel" id="panel-0">
    <div class="br-pagetitle">
      <div>
      <br>
        <h4>Detail Penentuan</h4>
      </div>
    </div>

    <div class="br-pagebody">
  
  <div class="row">
    <div class="col-lg-12 widget-2 px-0">
      <div class="card shadow-base">
        <div class="card-header">
          <h6 class="card-title float-left">Penentuan Sasaran Tujuan</h6>
          <div class="float-right">

            <a class="btn btn-sm btn-success" href="#" onclick="window.print()"><i class="menu-item-icon icon ion-print-outline"></i> Print</a>
          </div>
        </div>
        <div><center><img class="img-fluid" style="width: 90%; margin: 10px" src="{{ asset('img/detail2.png') }}"></center></div>
      </div>
    </div>
  </div>
</div>
    


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
       
       <script type="text/javascript">
  // Añade el CK Editor
CKEDITOR.editorConfig = function (config) {
    config.language = 'es';
    config.uiColor = '#F7B42C';
    config.height = 300;
    config.toolbarCanCollapse = true;
  };
  CKEDITOR.replace('editor1');

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