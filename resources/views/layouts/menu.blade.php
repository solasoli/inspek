<a href="/" class="br-menu-link">
  <div class="br-menu-item">
    <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
    <span class="menu-item-label">Dashboard</span>
  </div>
</a>

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

<a href="/upload_kode_rekening" class="br-menu-link">
  <div class="br-menu-item">
    <i class="menu-item-icon icon ion-ios-cloud-upload tx-22"></i>
    <span class="menu-item-label">Upload Kode Bank</span>
  </div>
</a>

<a href="/upload_rka" class="br-menu-link">
  <div class="br-menu-item">
    <i class="menu-item-icon icon ion-ios-cloud-upload tx-22"></i>
    <span class="menu-item-label">Upload RKA</span>
  </div>
</a>


<a href="{{ route('logout') }}" class="br-menu-link" onclick="event.preventDefault(); document.getElementById('logout-form2').submit();">
  <div class="br-menu-item">
    <i class="menu-item-icon icon ion-power tx-20"></i>
    <span class="menu-item-label">Sign Out</span>
    <form id="logout-form2" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
  </div>
</a>
