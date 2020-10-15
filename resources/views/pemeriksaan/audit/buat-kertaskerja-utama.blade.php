@extends('layouts.app')
@section('content')
<div class="br-mainpanel" id="panel-0">
    <div class="br-pagetitle">
      <div>
      <br>
        <h4>Kertas Kerja Utama</h4>
      </div>
    </div>

    <div class="br-pagebody">


    <div class="row row-sm mg-t-20">
      <div class="col-lg-12">
        


       
      <div class="card bd-0 shadow-base" style="margin-top: 20px; margin-bottom: 20px" >
        <div class="container" >
          <h5 class="mt-5">Kertas Kerja Utama Ikhtiar 1</h5>
          <div class="br-pagebody">


            <div class="row row-sm mg-t-20" style="margin-bottom: 40px">
              <div class="col-lg-12 widget-2 px-0">
                <div class="card shadow-base" style="box-shadow: 0 0 black">

                  <input type="hidden" name="count" value="1" />

                  <div class="card-header">
                    <p><input id="more_info7" name="more-info" type="checkbox" />
                     <span id="data1">Judul Kondisi</span></p>
                   </div>

                   <div id="conditional_part7" style="display: none;">
                    <div id="editor1" rows="5"><br></div>
                    <br>
                    <label for="sel1">Kode Temuan</label>
                    <table class="table table-borderless">
                      <tr>
                        <td><select class="form-control" id="sel1">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                            </select>
                        </td>
                        <td><select class="form-control" id="sel1">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                            </select>
                          </td>
                        <td><select class="form-control" id="sel1">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                            </select>
                          </td>
                      </tr>
                    </table>
                  </div>


                  <div class="card-header">
                    <p><input id="more_info2" name="more-info" type="checkbox" />
                     <span id="data1">Uraian Kondisi</span></p>
                   </div>
                   <div id="conditional_part2">
                    <div id="editor2" rows="5"></div><br>
                    <label for="sel1">Kode Temuan</label>
                    <table class="table table-borderless">
                      <tr>
                        <td><select class="form-control" id="sel1">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                            </select>
                        </td>
                        <td><select class="form-control" id="sel1">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                            </select>
                          </td>
                        <td><select class="form-control" id="sel1">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                            </select>
                          </td>
                          
                      </tr>
                    </table>
                  </div>

                  <div class="card-header">
                    <p><input id="more_info3" name="more-info" type="checkbox" />
                     <span id="data1">Kriteria</span></p>
                   </div>
                   <div id="conditional_part3">
                    <div id="editor3" rows="5"><br></div>
                  </div>

                  <div class="card-header">
                    <p><input id="more_info4" name="more-info" type="checkbox" />
                     <span id="data1">Sebab</span></p>
                   </div>

                   <div id="conditional_part4">
                    <div id="editor4" rows="5"><br></div>

                  </div>

                  <div class="card-header">
                    <p><input id="more_info5" name="more-info" type="checkbox" />
                     <span id="data1">Akibat</span></p>
                   </div>

                   <div id="conditional_part5">
                    <div id="editor5" rows="5"><br></div>

                  </div>

                  <div class="card-header">
                    <p><input id="more_info8" name="more-info" type="checkbox" />
                     <span id="data1">Rekomendasi</span></p>
                   </div>

                   <div id="conditional_part8" style="display: none;">
                    <div id="editor6" rows="5"></div>
                    <label for="sel1">Kode Temuan</label>
                    <table class="table table-borderless">
                      <tr>
                        <td><select class="form-control" id="sel1">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                            </select>
                        </td>
                        <td><select class="form-control" id="sel1">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                            </select>
                          </td>
                        <td><select class="form-control" id="sel1">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                            </select>
                          </td>
                          
                      </tr>
                    </table>
                  </div>
                  <center>
                    <label for="tambah" class="btn btn-info" style="width:30%; margin-top: 30px; margin-bottom: 30px">+ Tambah Kertas Kerja Ikhtisar
                      <input type="radio" id="tambah" name="chkPassPort" onclick="ShowHideDiv()" style="display: none;" />
                    </label>
                    <button class="btn btn-primary" style="width: 30%;">Simpan</button>
                  </center>
                </div>
              </div>
            </div>


          </div><!-- br-pagebody -->
        </div>
      </div>


      <div class="card bd-0 shadow-base" style="margin-top: 20px; margin-bottom: 20px" >
        <div class="container" id="tambah_anak" onclick="ShowHideDiv()" style="display: none;">
          <h5 class="mt-5">Kertas Kerja Utama Ikhtiar 2</h5>
          <div class="br-pagebody">


            <div class="row row-sm mg-t-20" style="margin-bottom: 40px">
              <div class="col-lg-12 widget-2 px-0">
                <div class="card shadow-base" style="box-shadow: 0 0 black">

                  <input type="hidden" name="count" value="1" />

                  <div class="card-header">
                    <p><input id="more_info9" name="more-info" type="checkbox" />
                     <span id="data1">Judul Kondisi</span></p>
                   </div>

                   <div id="conditional_part9" style="display: none;">
                    <div id="editor9" rows="5"><br></div>
                    <br>
                    <label for="sel1">Kode Temuan</label>
                    <table class="table table-borderless">
                      <tr>
                        <td><select class="form-control" id="sel1">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                            </select>
                        </td>
                        <td><select class="form-control" id="sel1">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                            </select>
                          </td>
                        <td><select class="form-control" id="sel1">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                            </select>
                          </td>
                      </tr>
                    </table>
                  </div>


                  <div class="card-header">
                    <p><input id="more_info10" name="more-info" type="checkbox" />
                     <span id="data1">Uraian Kondisi</span></p>
                   </div>
                   <div id="conditional_part10" style="display: none;">
                    <div id="editor10" rows="5"></div><br>
                    <label for="sel1">Kode Temuan</label>
                    <table class="table table-borderless">
                      <tr>
                        <td><select class="form-control" id="sel1">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                            </select>
                        </td>
                        <td><select class="form-control" id="sel1">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                            </select>
                          </td>
                        <td><select class="form-control" id="sel1">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                            </select>
                          </td>
                          
                      </tr>
                    </table>
                  </div>

                  <div class="card-header">
                    <p><input id="more_info11" name="more-info" type="checkbox" />
                     <span id="data1">Kriteria</span></p>
                   </div>
                   <div id="conditional_part11" style="display: none;">
                    <div id="editor11" rows="5"><br></div>
                  </div>

                  <div class="card-header">
                    <p><input id="more_info12" name="more-info" type="checkbox" />
                     <span id="data1">Sebab</span></p>
                   </div>

                   <div id="conditional_part12" style="display: none;">
                    <div id="editor12" rows="5"><br></div>

                  </div>

                  <div class="card-header">
                    <p><input id="more_info13" name="more-info" type="checkbox" />
                     <span id="data1">Akibat</span></p>
                   </div>

                   <div id="conditional_part13" style="display: none;">
                    <div id="editor13" rows="5"><br></div>

                  </div>

                  <div class="card-header">
                    <p><input id="more_info14" name="more-info" type="checkbox" />
                     <span id="data1">Rekomendasi</span></p>
                   </div>

                   <div id="conditional_part14" style="display: none;">
                    <div id="editor14" rows="5"></div>
                    <label for="sel1">Kode Temuan</label>
                    <table class="table table-borderless">
                      <tr>
                        <td><select class="form-control" id="sel1">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                            </select>
                        </td>
                        <td><select class="form-control" id="sel1">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                            </select>
                          </td>
                        <td><select class="form-control" id="sel1">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                            </select>
                          </td>
                          
                      </tr>
                    </table>
                  </div>
                  <center>
                    <label for="tambah" class="btn btn-info" style="width:30%; margin-top: 30px; margin-bottom: 30px"> + Tambah Kertas Kerja Ikhtisar
                <input type="radio" id="tambah" name="chkPassPort" onclick="ShowHideDiv()" style="display: none;" />
              </label>
                    <button class="btn btn-primary" style="width: 30%;">Simpan</button>
                  </center>
                </div>
              </div>
            </div>


          </div>
        </div>
      </div>

    </div><!-- row -->



    <br>


  </div>

  </div><!-- br-pagebody -->


       
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
  CKEDITOR.replace('editor9');
  CKEDITOR.replace('editor10');
  CKEDITOR.replace('editor11');
  CKEDITOR.replace('editor12');
  CKEDITOR.replace('editor13');
  CKEDITOR.replace('editor14');
  

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
         
         
         $('#more_info9').change(function() {
        if(this.checked != true){
          $("#conditional_part9").hide();
        }
        else{
          $("#conditional_part9").show();
        }
      });
      $('#more_info10').change(function() {
        if(this.checked != true){
          $("#conditional_part10").hide();
        }
        else{
          $("#conditional_part10").show();
        }
      });
      $('#more_info11').change(function() {
        if(this.checked != true){
          $("#conditional_part11").hide();
        }
        else{
          $("#conditional_part11").show();
        }
      });
      $('#more_info12').change(function() {
        if(this.checked != true){
          $("#conditional_part12").hide();
        }
        else{
          $("#conditional_part12").show();
        }
      });
      $('#more_info13').change(function() {
        if(this.checked != true){
          $("#conditional_part13").hide();
        }
        else{
          $("#conditional_part13").show();
        }
      });
      $('#more_info14').change(function() {
        if(this.checked != true){
          $("#conditional_part14").hide();
        }
        else{
          $("#conditional_part14").show();
        }
      });
       </script>
   
@endsection