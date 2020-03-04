<a href="/" class="br-menu-link  mg-b-20">
  <div class="br-menu-item">
    <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
    <span class="menu-item-label">Dashboard</span>
  </div>
</a>


<a href="#" class="br-menu-link">
  <div class="br-menu-item">
    <i class="menu-item-icon icon ion-ios-gear-outline tx-24"></i>
    <span class="menu-item-label">Master</span>
    <i class="menu-item-arrow fa fa-angle-down"></i>
  </div>
</a>
<ul class="br-menu-sub nav flex-column">
  <li class="nav-item"><a href="/mst/periode" class="nav-link">Periode</a></li>
  <li class="nav-item"><a href="/mst/skpd" class="nav-link">OPD</a></li>
  <li class="nav-item"><a href="/mst/pegawai" class="nav-link">Pegawai</a></li>
  <li class="nav-item"><a href="/mst/pegawai/inspektur" class="nav-link">Inspektur</a></li>
  <li class="nav-item"><a href="/mst/wilayah" class="nav-link">Wilayah Kerja</a></li>
  <!-- <li class="nav-item"><a href="/mst/inspektur_pembantu/form" class="nav-link">Inspektur Pembantu</a></li> -->
  <li class="nav-item"><a href="/mst/sasaran" class="nav-link">Sasaran</a></li>
  <li class="nav-item"><a href="/mst/dasar_surat" class="nav-link">Dasar Surat Perintah</a></li>
</ul>

<a href="#" class="br-menu-link">
  <div class="br-menu-item">
    <i class="menu-item-icon icon ion-ios-gear-outline tx-24"></i>
    <span class="menu-item-label">PKPT</span>
    <i class="menu-item-arrow fa fa-angle-down"></i>
  </div>
</a>
<ul class="br-menu-sub nav flex-column">
  <li class="nav-item"><a href="/pkpt/surat_perintah" class="nav-link">Surat Perintah</a></li>
  <li class="nav-item"><a href="/pkpt/surat_perintah/kalendar" class="nav-link">Kalendar</a></li>
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
</ul>



<a href="{{ route('logout') }}" class="br-menu-link" onclick="event.preventDefault(); document.getElementById('logout-form2').submit();">
  <div class="br-menu-item">
    <i class="menu-item-icon icon ion-power tx-20"></i>
    <span class="menu-item-label">Sign Out</span>
    <form id="logout-form2" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
  </div>
</a>
