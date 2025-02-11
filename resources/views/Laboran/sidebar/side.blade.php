<aside id="sidebar" class="sidebar small">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('dlaboran')}}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>
    @if (session('level') !='Mahasiswa')
    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('akun') }}">
      <i class="bi bi-book"></i>
        <span>Daftar Peminjaman</span>
      </a>
    </li>
    @endif
    @if (session('level') == 'Developer' || (session('level') == 'Dosen'))
    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('daftarakun') }}">
        <i class="bi bi-people"></i>
        <span>Daftar Akun</span>
      </a>
    </li>
    @endif
    <li class="nav-item">
      <a class="nav-link collapsed" href="{{route('ruang')}}">
        <i class="bi bi-door-open"></i>
        <span>Ruangan</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link collapsed" href="{{route('bahan')}}">
        <i class="bi bi-box-seam"></i>
        <span>Bahan</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link collapsed" href="{{route('alat')}}">
        <i class="bi bi-tools"></i>
        <span>Alat</span>
      </a>
    </li>
    @if (session('level') !='Mahasiswa')
    <li class="nav-item">
      <a class="nav-link collapsed" href="{{route('alat.ucak')}}">
        <i class="bi bi-exclamation-triangle"></i>
        <span>Alat Rusak</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link collapsed" href="{{route('beli')}}">
        <i class="bi bi-cart4"></i>
        <span>Pembelian</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link collapsed" href="{{route('Riwayat')}}">
        <i class="bi bi-clock-history"></i>
        <span>Riwayat Peminjaman</span>
      </a>
    </li>
    @endif
  </ul>
</aside>

