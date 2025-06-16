<?=$this->load->view('publik/ui2/header')?>

        <section class="main">

            <div class="featured-list container">

               <div class="row">
                    <div class="col-xs-12">
                        <div class="aboutbox-item">
                            <h3 class="featured-title"><span>Email Confirmation</span></h3>
                        
                            <?php if(isset ($belum_diaktifkan)) { ?><strong>TERIMA KASIH!</strong>
                            <p>
                            Anda telah berhasil melakukan pendaftaran Member CipikaStore dengan menggunakan email

                            <strong><?=$email?></strong> Silahkan cek email Anda dan ikuti petunjuk validasi yang telah kami kirimkan.</p>
                            <p>
                            Apabila Anda belum menerima atau menemukan email yang kami maksud, silahkan ikuti langkah-
                            langkah berikut:</p>
                            <ol>
                            <li>Cek folder email Spam atau Bulk Anda.</li>

                            <li>Terdapat kemungkinan, filter email Anda mendeteksi email yang kami kirim sebagai spam atau bulk.</li>

                            <li>Kirimkan permintaan email validasi baru.</li>

                            <li>Kunjungi beranda CipikaStore dan cobalah masuk (Sign In) dengan akun yang telah Anda daftarkan.</li>

                            <li>Apabila akun tidak diterima, tekan Link permintaan email validasi dan segera cek kembali email Anda.</li>

                            <li>Daftarkan ulang diri Anda sebagai Member CipikaStore.</li>

                            </ol>
                            <p>
                            Dengan menggunakan alamat email yang sama. Apabila alamat email terlah terdaftar, maka pendaftaran

                            tidak akan diproses. Segera hubungi <a href="mailto:e-care.store@cipika.co.id">e-care.store@cipika.co.id</a> untuk mendapatkan email validasi

                            Anda. Sebaliknya, apabila pendaftaran berhasil dilakukan, cek kemungkinan kesalahan pengetikan 

                            alamat email pada pendaftaran sebelumnya dan segera lakukan validasi akun Member CipikaStore

                            Anda.</p>
                              <?php } else { if($aktivasi_berhasil == TRUE)  { ?>
                              <p>Member CipikaStore Yth.</p>

                              <p>Akun Anda sudah aktif. Selamat berbelanja.</p>

                              <p>Terima kasih</p>
                              <?php } else { ?>
                              <p>Maaf Aktifasi Anda gagal, silakan daftar kembali.</p>

                              <p>Terima kasih</p>
                              <?php } } ?>
            
                        </div>
                    </div>
                </div>

        </section>
<?=$this->load->view('publik/ui2/footer')?>
