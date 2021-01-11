<a href="/" class="br-menu-link  mg-b-20">
  <div class="br-menu-item">
    <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
    <span class="menu-item-label">Dashboard</span>
  </div>
</a>

@php
use App\Repository\ACL\Menu;
$menu = Menu::where("is_deleted", 0)
->where("id_parent", 0)
->whereIn("id", getAllParentMenuUser())
->where("level", 1)->get();

global $menu_html;
foreach($menu as $idx => $row){
  //check child
  $menu_html .= getChildMenu($row->id);
}

echo $menu_html;

function getChildMenu($menu_id) {
  $menu_child_html = "";
  $get_child = Menu::where("is_deleted", 0)->where("id_parent", $menu_id)->orderBy('order', 'ASC')->get();
  $parent_row = Menu::where("is_deleted", 0)->where("id", $menu_id)->first();
  if($get_child != null && $get_child->count() > 0){
    if(can_access_child($parent_row->slug) === true){
      $menu_child_html .= "<a href='#' class='br-menu-link'><div class='br-menu-item'><i class='menu-item-icon icon ion-ios-gear-outline tx-24'></i><span class='menu-item-label'>". $parent_row->nama. "</span><i class='menu-item-arrow fa fa-angle-down'></i></div></a>
      <ul class='br-menu-sub nav flex-column'>";

      foreach($get_child as $ix => $rw){

        if($rw->have_child == 1){
          $menu_child_html .= getChildMenu($rw->id);
        }
        else
        {
          if(can_access($rw->slug)){
            $menu_child_html .= "<li class='nav-item'><a href='{$rw->url}' class='nav-link'>{$rw->nama}</a></li>";
          }
        }
      }
      $menu_child_html .= "</ul>";
    }
  }
  else {
    $menu_child_html .= "<a href=\"{$parent_row->url}\" class=\"br-menu-link  mg-b-20\">
      <div class=\"br-menu-item\">
        <i class=\"menu-item-icon icon ion-ios-gear-outline tx-22\"></i>
        <span class=\"menu-item-label\">{$parent_row->nama}</span>
      </div>
    </a>";
  }

  return $menu_child_html;
}
@endphp
{{--
<a href='#' class='br-menu-link'>
  <div class='br-menu-item'>
    <i class='menu-item-icon icon ion-ios-gear-outline tx-24'></i>
    <span class='menu-item-label'>Master</span>
    <i class='menu-item-arrow fa fa-angle-down'></i>
  </div>
</a>
<ul class='br-menu-sub nav flex-column'>
  <li class='nav-item'><a href='cd/mst/skpd' class='nav-link'>Perangkat Daerah</a></li>
  <li class='nav-item'><a href='/mst/pegawai' class='nav-link'>Data Pegawai</a></li>
  <li class='nav-item'><a href='/mst/struktur' class='nav-link'>Struktur Organigram</a></li>
  <li class='nav-item'><a href='/mst/kegiatan' class='nav-link'>Kegiatan</a></li>
  <li class='nav-item'><a href='/mst/program_kerja' class='nav-link'>Program Kerja</a></li>
</ul>

<a href="#" class="br-menu-link">
  <div class="br-menu-item">
    <i class="menu-item-icon icon ion-ios-gear-outline tx-24"></i>
    <span class="menu-item-label">Surat Perintah</span>
    <i class="menu-item-arrow fa fa-angle-down"></i>
  </div>
</a>
<ul class="br-menu-sub nav flex-column">
  <li class="nav-item"><a href="/pkpt/surat_perintah" class="nav-link">Buat Surat Perintah</a></li>
  <li class="nav-item"><a href="/pkpt/surat_perintah/Nomor" class="nav-link">PeNomoran Surat</a></li>
  <li class="nav-item"><a href="/pkpt/surat_perintah/kalendar" class="nav-link">Kalender Kerja</a></li>
</ul>

<a href="#" class="br-menu-link">
  <div class="br-menu-item">
    <i class="menu-item-icon icon ion-ios-gear-outline tx-24"></i>
    <span class="menu-item-label">Pemeriksaan</span>
    <i class="menu-item-arrow fa fa-angle-down"></i>
  </div>
</a>
<ul class="br-menu-sub nav flex-column">
  <li class="nav-item"><a href="/pemeriksaan/sasaran-tujuan" class="nav-link">Penentuan Sasaran Tujuan</a></li>
  <li class="nav-item"><a href="/pemeriksaan/program-kerja-audit" class="nav-link">Program Kerja Audit</a></li>
  <li class="nav-item"><a href="/pemeriksaan/audit" class="nav-link">Melakukan Audit</a></li>
  <li class="nav-item"><a href="/pemeriksaan/irban/draft-nhp" class="nav-link">Laporan NHP</a></li>
  <li class="nav-item"><a href="/pemeriksaan/irban/lhp-tinjut" class="nav-link">Laporan LHP</a></li>
</ul>

<a href="#" class="br-menu-link">
  <div class="br-menu-item">
    <i class="menu-item-icon icon ion-ios-gear-outline tx-24"></i>
    <span class="menu-item-label">Tindak Lanjut</span>
    <i class="menu-item-arrow fa fa-angle-down"></i>
  </div>
</a>
<ul class="br-menu-sub nav flex-column">
  <li class="nav-item"><a href="" class="nav-link">Matrik Tindak Lanjut</a></li>
  <li class="nav-item"><a href="" class="nav-link">Progress Tindak Lanjut</a></li>
</ul>

<a href="#" class="br-menu-link">
  <div class="br-menu-item">
    <i class="menu-item-icon icon ion-ios-gear-outline tx-24"></i>
    <span class="menu-item-label">Angka Kredit</span>
    <i class="menu-item-arrow fa fa-angle-down"></i>
  </div>
</a>
<ul class="br-menu-sub nav flex-column">
  <li class="nav-item"><a href="/angka-kredit/tim-penilai/penilaian-angka-kredit" class="nav-link">Perhitungan Angka Kredit</a></li>
</ul>


<label class="sidebar-label pd-x-15 mg-t-25 mg-b-20 tx-info op-9">Upload</label>
<a href="/upload_kode_rekening" class="br-menu-link">
  <div class="br-menu-item">
    <i class="menu-item-icon icon ion-ios-cloud-upload tx-22"></i>
    <span class="menu-item-label">Upload Kode Bank</span>
  </div>
</a>


<a href="#" class="br-menu-link">
  <div class="br-menu-item">
    <i class="menu-item-icon icon ion-ios-gear-outline tx-24"></i>
    <span class="menu-item-label">RKA</span>
    <i class="menu-item-arrow fa fa-angle-down"></i>
  </div>
</a>
<ul class="br-menu-sub nav flex-column">
  <li class="nav-item"><a href="/upload_rka" class="nav-link">Upload RKA</a></li>
  <li class="nav-item"><a href="/rka" class="nav-link">RKA</a></li>
</ul>
--}}

@if(Auth::user()->id_role == 1)
  <label class="sidebar-label pd-x-15 mg-t-25 mg-b-20 tx-info op-9">Setting</label>

  <a href="#" class="br-menu-link">
    <div class="br-menu-item">
      <i class="menu-item-icon icon ion-ios-gear-outline tx-24"></i>
      <span class="menu-item-label">ACL</span>
      <i class="menu-item-arrow fa fa-angle-down"></i>
    </div>
  </a>
  <ul class="br-menu-sub nav flex-column">
    <li class="nav-item"><a href="/acl/role" class="nav-link">Role</a></li>
    <li class="nav-item"><a href="/acl/menu" class="nav-link">Menu</a></li>
    <li class="nav-item"><a href="/acl/permission" class="nav-link">Permission</a></li>
    <li class="nav-item"><a href="/acl/user" class="nav-link">User</a></li>
  </ul>

  <a href="#" class="br-menu-link">
    <div class="br-menu-item">
      <i class="menu-item-icon icon ion-ios-gear-outline tx-24"></i>
      <span class="menu-item-label">Developer Setting</span>
      <i class="menu-item-arrow fa fa-angle-down"></i>
    </div>
  </a>
  <ul class="br-menu-sub nav flex-column">
    <li class="nav-item"><a href="/dev/config" class="nav-link">Config</a></li>
    <li class="nav-item"><a href="/mst/jabatan" class="nav-link">Jabatan</a></li>
    <li class="nav-item"><a href="/mst/peran" class="nav-link">Peran Irban</a></li>
    <li class="nav-item"><a href="/mst/wilayah" class="nav-link">Kelola Irban</a></li>
    <li class="nav-item"><a href="/mst/pegawai/inspektur" class="nav-link">Inspektur</a></li>
    <li class="nav-item"><a href="/mst/inspektur_pembantu/form" class="nav-link">Inspektur Pembantu</a></li>
    <li class="nav-item"><a href="/mst/dasar_surat" class="nav-link">Dasar Surat Perintah</a></li>
  </ul>
@endif

<a href="{{ route('logout') }}" class="br-menu-link" onclick="event.preventDefault(); document.getElementById('logout-form2').submit();">
  <div class="br-menu-item">
    <i class="menu-item-icon icon ion-power tx-20"></i>
    <span class="menu-item-label">Sign Out</span>
    <form id="logout-form2" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
  </div>
</a>
