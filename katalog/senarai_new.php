<?php
// $conn->debug=true;
$kampus=isset($_REQUEST["kampus"])?$_REQUEST["kampus"]:"";
$skat=isset($_REQUEST["subkategori"])?$_REQUEST["subkategori"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$subkategori=isset($_REQUEST["subkategori"])?$_REQUEST["subkategori"]:"";
$bidang=isset($_REQUEST["bidang"])?$_REQUEST["bidang"]:"";
// require_once 'common.php';

?>
   
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <!-- <img class="img-fluid" src="assets/img/logos/logo_ilim.jpg" alt="" style="height: 50px;" />&nbsp; -->
                <a class="navbar-brand js-scroll-trigger" href="#page-top">Sistem ITIS</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ml-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ml-auto">
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#page-top">Utama</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#katalog_kursus">Katalog Kursus</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#status_permohonan">Status Permohonan</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#contact">Hubungi Kami</a></li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">Login <i class="fas fa-sort-down"></i></a>
                            <!-- <a class="nav-link has-dropdown" data-toggle="dropdown" href="#about">PENERBITAN</a> -->
                            <ul class="dropdown-menu">
                                <li><a style="color:#000000;" class="nav-link" href="admin">Admin</a></li>
                                <li><a style="color:#000000;" class="nav-link" href="login/login_pensyarah.php">Pensyarah</a></li>
                                <li><a style="color:#000000;" class="nav-link" href="login/login_peserta.php">Peserta</a></li>
                                <li><a style="color:#000000;" class="nav-link" href="login/login_asrama.php">Domestik</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead" style="padding-top:150px;">
            <div class="container">
                <div class="card" style="background-color: rgba(0, 0, 0, 0.39);">
                    <div class="card-body">
                        <div class="masthead-subheading">Selamat Datang Ke</div>
                        <div class="masthead-heading text-uppercase">Sistem Maklumat Latihan Bersepadu ILIM</div>
                        <a class="btn btn-primary btn-xl text-uppercase js-scroll-trigger" href="#katalog_kursus">Katalog Kursus</a>
                    </div>
                </div>
                 
            </div>
        </header>
        <!-- katalog_kursus-->
        <section class="page-section" id="katalog_kursus">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Katalog Kursus</h2>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <tbody>
                            <tr>
                                <td width="100%">
                                    Sila pilih pusat/bidang bagi mendapatkan maklumat yang dikehendaki. <br><br>
                                    <div class="row">
                                        <?php 
                                            $sqlkks = "SELECT * FROM _ref_kampus WHERE kampus_status=0";
                                            $rskks = $conn->Execute($sqlkks);
                                        ?>
                                        
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label><b>Pusat Latihan : </b></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                        </div>

                                        <?php 
                                            $sqlkks = "SELECT * FROM _tbl_kursus_catsub WHERE is_deleted=0 AND f_category_code=1 AND f_status=0 
                                            ORDER BY SubCategoryNm";
                                        ?>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label><b>Bidang : </b></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <table width="100%" align="center" cellpadding="2" cellspacing="0" border="0">
                                <tr> 
                                    <td align="left" style="padding-left:5px">Jumlah Rekod : <b>0</b></td>
                                    <td align="right"><b>Sebanyak 
                                        <select name="linepage" onChange="do_page('index.php?data=dXNlcjtzZW5hcmFpLnBocDtrdXJzdXM7')">
                                        <option value="10" selected>10</option>
                                        <option value="20" >20</option>
                                        <option value="50" >50</option>
                                        <option value="100" >100</option>
                                        </select> rekod dipaparkan bagi setiap halaman.&nbsp;&nbsp;&nbsp;</b> 
                                    </td>
                                </tr>
                                <tr valign="top" bgcolor="#fed136"> 
                                    <td height="30" colspan="5" valign="middle">
                                        <font size="2" face="Arial, Helvetica, sans-serif">
                                        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT KATALOG KURSUS</strong></font>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" align="center" style="padding: 0px;">
                                        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#000000">
                                            <tr bgcolor="#CCCCCC">
                                            <td width="5%" align="center"><b>Bil</b></td>
                                            <td width="10%" align="center"><b>Kod Kursus</b></td>
                                            <td width="45%" align="center"><b>Diskripsi Kursus</b></td>
                                            <td width="10%" align="center"><b>Bidang</b></td>
                                            <td width="10%" align="center"><b>Tempat Kursus</b></td>
                                            <td width="10%" align="center"><b>Tarikh Kursus</b></td>
                                            <td width="10%" align="center"><b>Status</b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="10" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td>
                                            </tr>
                                        </table> 
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5"></td>
                                </tr>
                            </table>
                        </tbody>
                    </div>
                </div>
            </div>
        </section>
        <!-- status_permohonan Grid-->
        <section class="page-section bg-light" id="status_permohonan">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Status Permohonan</h2>
                </div>
                <form name="ilim" method="post">
                    <div style="background-color: #fed136;" align="center">Sila masukkan No. kad Pengenalan anda / Kad Kuasa (Polis/Tentera)</div><br>
                    <div class="row">
                        <div class="col-md-1">
                            <div class="form-group">
                                <input class="form-control" id="" type="hidden" required="required" data-validation-required-message="Sila masukkan no kad pengenalan anda." />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label><b>No. Kad Pengenalan : </b></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="form-control" id="" type="text" required="required" data-validation-required-message="Sila masukkan no kad pengenalan anda." />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="success"></div>
                                <button class="btn btn-primary btn-md text-uppercase" id="sendMessageButton" type="submit">Semak</button>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <input class="form-control" id="" type="hidden" required="required" data-validation-required-message="Sila masukkan no kad pengenalan anda." />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section><br><br><br><br><br>
        <!-- About-->
        <!-- <section class="page-section" id="about">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">About</h2>
                    <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
                </div>
                <ul class="timeline">
                    <li>
                        <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/about/1.jpg" alt="" /></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4>2009-2011</h4>
                                <h4 class="subheading">Our Humble Beginnings</h4>
                            </div>
                            <div class="timeline-body"><p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p></div>
                        </div>
                    </li>
                    <li class="timeline-inverted">
                        <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/about/2.jpg" alt="" /></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4>March 2011</h4>
                                <h4 class="subheading">An Agency is Born</h4>
                            </div>
                            <div class="timeline-body"><p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p></div>
                        </div>
                    </li>
                    <li>
                        <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/about/3.jpg" alt="" /></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4>December 2012</h4>
                                <h4 class="subheading">Transition to Full Service</h4>
                            </div>
                            <div class="timeline-body"><p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p></div>
                        </div>
                    </li>
                    <li class="timeline-inverted">
                        <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/about/4.jpg" alt="" /></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4>July 2014</h4>
                                <h4 class="subheading">Phase Two Expansion</h4>
                            </div>
                            <div class="timeline-body"><p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p></div>
                        </div>
                    </li>
                    <li class="timeline-inverted">
                        <div class="timeline-image">
                            <h4>
                                Be Part
                                <br />
                                Of Our
                                <br />
                                Story!
                            </h4>
                        </div>
                    </li>
                </ul>
            </div>
        </section> -->
        <!-- Contact-->
        <!--Footer section start-->
        <section class="page-section" id="contact" style="padding: 15px;">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Hubungi Kami</h2>
                </div>
                <br>
                <div class="row row-25">				                    
                    <!--Footer Widget start-->
                    <div class="footer-widget col-lg-3 col-md-3 col-12 mb-40">
                        <h5 class="title"><span class="text-white"><b>Media Sosial</b></span></h5>
                        <div class="footer-social">
                            <a class="btn btn-primary btn-social mx-2" href="#!"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-primary btn-social mx-2" href="#!"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-social mx-2" href="#!"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <!--Footer Widget end-->

                    <!--Footer Widget start-->
                    <div class="footer-widget col-lg-4 col-md-4 col-12 mb-40">
                        <h5 class="title"><span class="text-white"><b>Lokasi</b></span></h5>
                        <h7 style="color:#fed136;">
                            Institut Latihan Islam Malaysia (ILIM),<br>
                            12, Jalan Maktab, <br>
                            Seksyen 12, <br>
                            43650 Bangi,<br>
                            Selangor.
                        </h7>
                    </div>
                    <!--Footer Widget end-->

                    <!--Footer Widget start-->
                    <div class="footer-widget col-lg-2 col-md-2 col-12 mb-40">
                        <h5 class="title"><span class="text-white"><b>Hubungi Kami</b></span></h5>
                        <h7 style="color:#fed136;">Tel: 03-8921 8500 <br>Fax: 03-89218500</h7>             
                    </div>
                    <!--Footer Widget end-->


                    <!--Footer Widget start-->
                    <div class="footer-widget col-lg-3 col-md-3 col-12 mb-40">
                        <h5 class="title"><span class="text-white"><b>Pengunjung</b></span></h5>
                        
                        <h7 style="color:#fed136;">
                            Jumlah : <span name="totalvis" id="totalvis"></span><br>
                            Hari Ini : <span name="todayvis" id="todayvis"></span><br>
                            Kelmarin : <span name="yesterdayvis" id="yesterdayvis"></span><br>
                            Bulan Ini : <span name="thismonthvis" id="thismonthvis"></span><br>
                            Bulan Lepas : <span name="lastmonthvis" id="lastmonthvis"></span><br>
                        </h7>
                    </div>
                    <!--Footer Widget end-->    
                </div>
            </div>
        </section>
        <!--Footer section end--> 
        <!-- Footer-->
        <footer class="footer" style="background-color: #fed136;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-12 text-center"><b>Copyright © Your Website 2020</b></div>
                </div>
            </div>
        </footer>
        <!-- Portfolio Modals-->
        <!-- Modal 1-->
        <div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-dismiss="modal"><img src="assets/img/close-icon.svg" alt="Close modal" /></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                                    <!-- Project Details Go Here-->
                                    <h2 class="text-uppercase">Project Name</h2>
                                    <p class="item-intro text-muted">Lorem ipsum dolor sit amet consectetur.</p>
                                    <img class="img-fluid d-block mx-auto" src="assets/img/portfolio/01-full.jpg" alt="" />
                                    <p>Use this area to describe your project. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est blanditiis dolorem culpa incidunt minus dignissimos deserunt repellat aperiam quasi sunt officia expedita beatae cupiditate, maiores repudiandae, nostrum, reiciendis facere nemo!</p>
                                    <ul class="list-inline">
                                        <li>Date: January 2020</li>
                                        <li>Client: Threads</li>
                                        <li>Category: Illustration</li>
                                    </ul>
                                    <button class="btn btn-primary" data-dismiss="modal" type="button">
                                        <i class="fas fa-times mr-1"></i>
                                        Close Project
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

