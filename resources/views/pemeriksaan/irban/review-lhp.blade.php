@extends('layouts.app')
@section('content')
<script src="https://cdn.ckeditor.com/ckeditor5/20.0.0/classic/ckeditor.js"></script>
<div class="br-mainpanel" style="margin: 0px;">
    <div class="br-pagetitle">
      <div style="padding-top: 20px">
        <h5>Review LHP</h5>
      </div>
    </div>

    <div class="br-pagebody">


        <div class="row row-sm mg-t-20">
          <div class="col-lg-12">
            


           
            <div class="card bd-0 shadow-base" style="margin-top: 20px; margin-bottom: 20px" >
              <div class="container" >
                <form action="">

                  <div class="input-group control-group after-add-more mt-5">
                    
                    <div class="form-group w-100">
                      <label for="nama"><b>Kertas Kerja Rinci</b></label>
                      <table class="table table-borderless">
                      <tr>
                        <td><input type="file" name="" class="form-control w-100" placeholder="Enter Name Here"></td>
                      </tr>
                      <tr>
                        <td><input type="file" name="" class="form-control w-100" placeholder="Enter Name Here"></td>
                      </tr>
                      <tr>
                        <td><input type="file" name="" class="form-control w-100" placeholder="Enter Name Here"></td>
                      </tr>
                    
                    </table>
                    <table class="table table-borderless">
                      
                      <tr>
                        <td><b>Uraian Singkat</b></td>
                        <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</td>
                      </tr>
                    </table>
                    </div>

                    
                  


                  </div>
                </form>
                
                <div class="card-header" style="background-color: white">
                  <p><input id="more_info" name="more-info" type="checkbox" />
                   <span id="data1">Merevisi Kertas Kerja Rinci</span></p>
                 </div>

                 <div id="conditional_part">
                  <table class="table">
                    <tr>
                      <td><textarea class="form-control" rows="4"></textarea></td>
                    </tr>
                    
                  </table>
                </div>


                <h5 class="mt-5">Kertas Kerja Utama Ikhtiar 1</h5>
                <div class="br-pagebody">

                 <table class="table table-borderless">
                  
                  <tr>
                    <td><b>Judul Kondisi</b></td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                      <b>Kode Temuan : 1 , 2 ,3</b>
                      <div class="card-header" style="background: white;">
                        <p><input id="more_info7" name="more-info" type="checkbox" />
                         <span id="data1">Revisi Judul Kondisi</span></p>
                       </div>

                       <div id="conditional_part7" style="display: none;">
                        <textarea class="form-control" rows="4"></textarea>
                        <br>
                        
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><b>Uraian Kondisi</b></td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                      <b>Kode Temuan : 1 , 2 ,3</b>
                      <div class="card-header" style="background: white;">
                        <p><input id="more_info2" name="more-info" type="checkbox" />
                         <span id="data1">Revisi Uraian Kondisi</span></p>
                       </div>
                       <div id="conditional_part2">
                        <textarea class="form-control" rows="4"></textarea>
                        
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><b>Kriteria</b></td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                      <div class="card-header" style="background: white;">
                        <p><input id="more_info3" name="more-info" type="checkbox" />
                         <span id="data1">Revisi Kriteria</span></p>
                       </div>
                       <div id="conditional_part3">
                        <textarea class="form-control" rows="4"></textarea>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><b>Sebab</b></td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                      <div class="card-header" style="background: white;">
                        <p><input id="more_info4" name="more-info" type="checkbox" />
                         <span id="data1">Revisi Sebab</span></p>
                       </div>

                       <div id="conditional_part4">
                        <textarea class="form-control" rows="4"></textarea>

                      </div>

                    </td>
                  </tr>
                  <tr>
                    <td><b>Akibat</b></td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                      <div class="card-header" style="background: white;">
                        <p><input id="more_info5" name="more-info" type="checkbox" />
                         <span id="data1">Revisi Akibat</span></p>
                       </div>

                       <div id="conditional_part5">
                        <textarea class="form-control" rows="4"></textarea>

                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><b>Rekomendasi</b></td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                      <b>Kode Temuan : 1 , 2 ,3</b>
                      <div class="card-header" style="background: white;">
                        <p><input id="more_info8" name="more-info" type="checkbox" />
                         <span id="data1">Revisi Rekomendasi</span></p>
                       </div>

                       <div id="conditional_part8" style="display: none;">
                        <textarea class="form-control" rows="4"></textarea>
                        
                      </div>
                    </td>
                  </tr>
                </table>

                <div class="row row-sm mg-t-20" style="margin-bottom: 40px">
                  <div class="col-lg-12 widget-2 px-0">
                    <div class="card shadow-base" style="box-shadow: 0 0 black">

                      <input type="hidden" name="count" value="1" />

                      


                      

                      

                      
                      

                      
                      
                      <center>
                       
                        <button class="btn btn-primary" style="width: 30%;">Simpan</button>
                      </center>
                    </div>
                  </div>
                </div>


              </div><!-- br-pagebody -->
            </div>
          </div>


          

        </div><!-- row -->



        <br>


      </div><!-- br-pagebody -->

    </div><!-- br-mainpanel -->

</div>

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

    