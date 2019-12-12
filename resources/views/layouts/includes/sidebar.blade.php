<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{asset('admin/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Inventori Barang</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('admin/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
          <li class="nav-item">
          <a href="{{route('dashboard')}}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="{{route('barang')}}" class="nav-link">
              <i class="nav-icon fas fa-box"></i>
              <p>
                Master Barang
              </p>
            </a>
          </li>
          {{-- <li class="nav-item">
          <a href="{{route('supplier')}}" class="nav-link">
              <i class="nav-icon fas fa-truck-moving"></i>
              <p>
                Supplier
              </p>
            </a>
          </li> --}}
          <li class="nav-item has-treeview">
            <a href="" class="nav-link">
                <i class="nav-icon fas fa-money-bill-alt"></i>
                <p>
                  Transaksi
                </p>
                <i class="right fas fa-angle-left"></i>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('tr_keluar')}}" class="nav-link">
                        <i class="nav-icon fas fa-cash-register"></i>
                        <p>
                          Transaksi Barang Keluar
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                    <a href="{{route('tr_masuk')}}" class="nav-link">
                        <i class="nav-icon fas fa-truck-loading"></i>
                        <p>
                          Transaksi Barang Masuk
                        </p>
                      </a>
                    </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
              <a href="" class="nav-link">
                  <i class="nav-icon fas fa-chart-bar"></i>
                  <p>
                    Laporan
                  </p>
                  <i class="right fas fa-angle-left"></i>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="{{route('laporan_keluar')}}" class="nav-link">
                          <i class="nav-icon fas fa-file-alt"></i>
                          <p>
                            Laporan Barang Keluar
                          </p>
                        </a>
                      </li>
              </ul>
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>