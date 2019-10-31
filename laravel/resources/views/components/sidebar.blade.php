<!-- BEGIN MAIN SIDEBAR -->
<nav id="sidebar">
    <div id="main-menu">
        <ul class="sidebar-nav">
            <li>
                <a href="{{ url('dashboard') }}"><i class="fa fa-home"></i><span class="sidebar-text">Profile Desa</span></a>
            </li>
            <li>
                <a href="{{ url('modul-kependudukan') }}"><i class="fa fa-desktop"></i><span class="sidebar-text">Modul Penduduk</span></a>
            </li>
            @if (Auth::user()->canAccess('kependudukan'))
            <li>
                <a href="#"><i class="fa fa-group"></i><span class="sidebar-text">Kependudukan</span><span class="fa arrow"></span></a>
                <ul class="submenu collapse">
                    <li>
                        <a href="{{ url("penduduk/statistik") }}"><span class="sidebar-text">Statistik</span></a>
                    </li>
                    <li>
                        <a href="{{ url("keluarga") }}"><span class="sidebar-text">Keluarga</span></a>
                    </li>
                    <li>
                        <a href="{{ url("penduduk") }}"><span class="sidebar-text">Penduduk</span></a>
                    </li>
                    <li>
                        <a href="{{ url("penduduk/daftar-pemilih-tetap") }}"><span class="sidebar-text">DPT</span></a>
                    </li>
                    <li>
                        <a href="#"><span class="sidebar-text">Kemiskinan</span><span class="fa arrow"></span></a>
                        <ul class="submenu collapse">
                            <li>
                                <a href="{{ url("kemiskinan") }}"><span class="sidebar-text" style="padding-left: 20px">Data Kemiskinan</span></a>
                            </li>
                            <li>
                                <a href="{{ url("audit-kemiskinan") }}"><span class="sidebar-text" style="padding-left: 20px">Audit</span></a>
                            </li>
                            <li>
                                <a href="{{ url("penerima-bantuan") }}"><span class="sidebar-text" style="padding-left: 20px">Penerima Bantuan</span></a>
                            </li>
                            <li>
                                <a href="{{ url("jenis-bantuan") }}"><span class="sidebar-text" style="padding-left: 20px">Jenis Bantuan</span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><span class="sidebar-text">Peristiwa</span><span class="fa arrow"></span></a>
                        <ul class="submenu collapse">
                            <li>
                                <a href="{{ url("kelahiran") }}"><span class="sidebar-text" style="padding-left: 20px">Kelahiran</span></a>
                            </li>
                            <li>
                                <a href="{{ url("kematian") }}"><span class="sidebar-text" style="padding-left: 20px">Kematian</span></a>
                            </li>
                            <li>
                                <a href="{{ url("kepindahan") }}"><span class="sidebar-text" style="padding-left: 20px">Kepindahan</span></a>
                            </li>
                            <li>
                                <a href="{{ url("migrasi") }}"><span class="sidebar-text" style="padding-left: 20px">Migrasi</span></a>
                            </li>
                            <li>
                                <a href="{{ url("pendatang") }}"><span class="sidebar-text" style="padding-left: 20px">Pendatang</span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            @endif
            @if (Auth::user()->canAccess('surat'))
            <li>
                <a href="#"><i class="fa fa-envelope"></i><span class="sidebar-text">Kesekretariatan</span><span class="fa arrow"></span></a>
                <ul class="submenu collapse">
                    <li>
                        <a href="{{ url("surat-masuk") }}"><span class="sidebar-text">Surat Masuk</span></a>
                    </li>
                    <li>
                        <a href="{{ url("surat-keluar") }}"><span class="sidebar-text">Surat Keluar</span></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-inbox"></i><span class="sidebar-text">Pelayanan Masyarakat</span><span class="fa arrow"></span></a>
                <ul class="submenu collapse">
                    <li>
                        <a href="{{ url("laporan-masuk") }}"><span class="sidebar-text">Laporan Masuk</span></a>
                    </li>
                    <li>
                        <a href="{{ url("pendaftaran") }}"><span class="sidebar-text">Pendaftaran Masyarakat</span></a>
                    </li>
                </ul>
            </li>
            @endif
            @if (Auth::user()->canAccess('pertanahan'))
            <li>
                <a href="#"><i class="fa fa-home"></i><span class="sidebar-text">Pertanahan</span><span class="fa arrow"></span></a>
                <ul class="submenu collapse">
                    <li>
                        <a href="{{ url("sertifikat-tanah") }}"><span class="sidebar-text">Sertifikat</span></a>
                    </li>
                    <li>
                        <a href="{{ url("kelas-tanah") }}"><span class="sidebar-text">Kelas Tanah</span></a>
                    </li>
                    <li>
                        <a href="{{ url("blok-tanah") }}"><span class="sidebar-text">Blok Tanah</span></a>
                    </li>
                </ul>
            </li>
            @endif
            @if (Auth::user()->canAccess('keuangan'))
            <li>
                <a href="https://siskeudes-banjarnegarakab.simdacloud.id/" target="_blank"><i class="fa fa-money"></i><span class="sidebar-text">Siskeudes</span></a>
                <!-- <ul class="submenu collapse">
                    <li>
                        <a href="{{ url("rpjm") }}"><span class="sidebar-text">RPJM</span></a>
                    </li>
                    <li>
                        <a href="{{ url("rkp") }}"><span class="sidebar-text">RKP</span></a>
                    </li>
                    <li>
                        <a href="{{ url("apbd") }}"><span class="sidebar-text">APBD Desa</span></a>
                    </li>
                    <li>
                        <a href="{{ url("pelaksanaan") }}"><span class="sidebar-text">Pelaksanaan</span></a>
                    </li>
                    <li>
                        <a href="#"><span class="sidebar-text">Master Data</span><span class="fa arrow"></span></a>
                        <ul class="submenu collapse">
                            <li>
                                <a href="{{ url("sumber-anggaran") }}"><span class="sidebar-text" style="padding-left: 20px">Sumber Anggaran</span></a>
                            </li>
                            <li>
                                <a href="{{ url("usaha-desa") }}"><span class="sidebar-text" style="padding-left: 20px">Usaha Desa</span></a>
                            </li>
                        </ul>
                    </li>
                </ul> -->
            </li>
            @endif
            @if (Auth::user()->canAccess('pengguna'))
            <li>
                <a href="#"><i class="fa fa-lock"></i><span class="sidebar-text">Akses</span><span class="fa arrow"></span></a>
                <ul class="submenu collapse">
                    <li>
                        <a href="{{ url("pengguna") }}"><span class="sidebar-text">Pengguna</span></a>
                    </li>
                    <li>
                        <a href="{{ url("role") }}"><span class="sidebar-text">Role</span></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-gear"></i><span class="sidebar-text">Pengaturan Umum</span><span class="fa arrow"></span></a>
                <ul class="submenu collapse">
                    <li>
                        <a href="{{ url("perangkat-desa") }}"><span class="sidebar-text">Perangkat Desa</span></a>
                    </li>
                    <li>
                        <a href="{{ url("pengaturan") }}"><span class="sidebar-text">Pengaturan Aplikasi</span></a>
                    </li>
                </ul>
            </li>
            @endif
        </ul>
    </div>
</nav>
<!-- END MAIN SIDEBAR -->