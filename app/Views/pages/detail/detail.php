<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<?php
if ($datapasien['tanggal_lahir'] == '0000-00-00') {
    $usia = '-';
} else {
    $tanggal = new DateTime($datapasien['tanggal_lahir']);
    $today = new DateTime('today');
    $y = $today->diff($tanggal)->y;
    $m = $today->diff($tanggal)->m;
    $d = $today->diff($tanggal)->d;
    $usia = $y . " tahun " . $m . " bulan " . $d . " hari";
}

?>

<div class="header-dashboard pt-4 pb-2 bg-white">
    <div class="container">
        <h5>
            <small>
                <a href="<?= base_url('/dashboard/dashboard'); ?>">Dashboard / </a>
            </small>
            Detail Data Pasien
        </h5>
    </div>
</div>
<div class="container bg-white mt-4 p-4 mb-4 shadow-sm">
    <!-- isi detail -->
    <div class="row mt-2 pr-2 pb-4">
        <!-- left side profile -->
        <div class="col-sm-3 text-center left-side-profile">
            <!-- image profile -->
            <div class="row">
                <div class="col">
                    <img src="/img/pasien/default.jpg" alt="" class="profile-page-detail img-fluid">
                </div>
            </div>
            <!-- data pasien -->
            <div class="row mt-4">
                <div class="col data-pasien-detail">
                    <h5>Nama</h5>
                    <p><?= $datapasien['nama']; ?></p>
                    <h5>Usia</h5>
                    <p><?= $usia; ?></p>
                    <h5>TB/BB</h5>
                    <p><?= $datapasien['tinggi_badan'] . '/' . $datapasien['berat_badan']; ?></p>
                </div>
            </div>
            <div class="row m-2">
                <!-- Button trigger modal detail data pasien-->
                <a href="" class="btn btn-lainya" data-toggle="modal" data-target="#modalLainya">Lainya<i class="fas fa-user-plus ml-2"></i></a>
            </div>
            <hr>
            <div class="row m-2">
                <a href="<?= base_url('/dashboard/lifestyle/edukasiperilaku/' . $datapasien['id_pasien']); ?>" class="btn btn-lifestyle">Lifestyle<i class="fas fa-calendar-check ml-2"></i></a>
            </div>
            <div class="row m-2">
                <a href="<?= base_url('/dashboard/Kepatuhan/detailkepatuhan/' . $datapasien['id_pasien']); ?>" class="btn btn-kepatuhan">Kepatuhan<i class="fas fa-calendar-check ml-2"></i></a>
            </div>
        </div>
        <!-- right side monitoring -->
        <div class="col-lg-9 right-side-detail pb-2">
            <!-- header -->
            <div class="row m-3">
                <div class="col title-monitoring-detail ">
                    <h4>Monitoring Pasien </h4>
                </div>
                <div class="col text-right">
                    <a href="<?= base_url('/dashboard/hasil/hasiltekanandarah/' . $datapasien['id_data_pasien']); ?>" class="btn btn-light border-secondary text-dark">Hasil<i class="fa fa-table ml-2"></i></a>
                </div>
            </div>
            <!-- card grafik -->
            <div class="row mr-3 ml-3">
                <div class="col bg-grafik-detail p-3">
                    <div id="grafik_tekanan_darah">

                    </div>
                </div>
            </div>
            <!-- analisis rekomendasi -->
            <div class="row m-3">
                <div class="col bg-analisis-rekomendasi p-3">
                    <div class="row">
                        <div class="col">
                            <?php if (session()->getFlashdata('pesan')) : ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= session()->getFlashdata('pesan'); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col title-analisis-rekomendasi">
                            <h5>Analisis dan Rekomendasi</h5>
                        </div>
                        <div class="col">
                            <a href="" class="btn btn-tambah-analisis float-right" data-toggle="modal" data-target="#modalAnalisis">+</a>
                        </div>
                    </div>
                    <!-- card analisis rekomendasi -->
                    <div class="row p-4">
                        <?php if ($analisisrekomendasi) { ?>

                            <?php foreach ($analisisrekomendasi as $ar) : ?>
                                <div class="col-sm-4">
                                    <div class="card-deck">
                                        <div class="card mb-2">
                                            <div class="card-header header-card-analisis">
                                                <?= $ar['tanggal_analisis']; ?>
                                            </div>
                                            <div class="card-body text-center">
                                                <small class="text-right warna-orange"><?= $ar['judul']; ?></small>
                                                <p class="card-text "><?= $ar['note_analisis']; ?></p>
                                            </div>
                                            <div class="card-footer p-0 text-right">
                                                <form action="/dashboard/detail/deleteanalisis/">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="id_analisis" value="<?= $ar['id_analisis']; ?>">
                                                    <button type="submit" class="btn text-danger " onclick="return confirm('apakah anda yakin ? ');"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php } else { ?>
                            <div class="col">
                                <h5 class="warna-abu-font text-center"><i class="far fa-folder-open mr-2"></i>belum ada data</h5>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Lainya -->
<div class="modal fade" id="modalLainya" tabindex="-1" aria-labelledby="modalLainyaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-danger mt-2 mr-2 float-right close-data-detail-pasien" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-9">
                    <h5 class="judul-detail-data-pasien pb-2"><i class="fas fa-user mr-2"></i>Biodata</h5>
                </div>
            </div>
            <div class="modal-body pb-0">
                <div class="row justify-content-center">
                    <div class="col-9 shadow-sm">
                        <table class="table table-borderless tabel-data-detail-pasien">
                            <tbody>
                                <tr>
                                    <td>Nama</td>
                                    <td>: <?= $datapasien['nama']; ?></td>
                                </tr>
                                <tr>
                                    <td>Puskesmas</td>
                                    <td>: <?= $namapuskesmas; ?></td>
                                </tr>
                                <tr>
                                    <td>Usia</td>
                                    <td>: <?= $usia; ?></td>
                                </tr>
                                <tr>
                                    <td>TB/BB</td>
                                    <td>: <?= $datapasien['tinggi_badan'] . '/' . $datapasien['berat_badan']; ?></td>
                                </tr>
                                <tr>
                                    <td>Alergi</td>
                                    <td>
                                        <?php if ($dataalergi) { ?> :
                                            <?php foreach ($dataalergi as $da) : ?>
                                                <?= $da['nama_alergi']; ?><br>:
                                                <?php endforeach; ?>-
                                            <?php } else { ?>
                                                : -
                                            <?php } ?>
                                    </td>
                                </tr>
                                </td>
                                </tr>
                                <tr>
                                    <td>Riwayat Penyakit</td>
                                    <td>
                                        <?php if ($datapenyakit) { ?> :
                                            <?php foreach ($datapenyakit as $da) : ?>
                                                <?= $da['nama_penyakit']; ?><br>:
                                                <?php endforeach; ?>-
                                            <?php } else { ?>
                                                : -
                                            <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Riwayat Pengobatan</td>
                                    <td>
                                        <?php if ($riwayatobat) { ?> :
                                            <?php foreach ($riwayatobat as $da) : ?>
                                                <?= $da['nama_obat']; ?><br>:
                                                <?php endforeach; ?>-
                                            <?php } else { ?>
                                                : -
                                            <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Riwayat Keluarga</td>
                                    <td>
                                        <?php if ($riwayatkeluarga) { ?> :
                                            <?php foreach ($riwayatkeluarga as $da) : ?>
                                                <?= $da['nama_penyakit']; ?>
                                                ,<?= $da['status_keluarga'] ?><br>:

                                                <?php endforeach; ?>-
                                            <?php } else { ?>
                                                : -
                                            <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Riwayat Diagnosa pengobatan</td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked disabled>
                                            <label class="form-check-label" for="exampleRadios1">
                                                < 1 Tahun </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2" disabled>
                                            <label class="form-check-label" for="exampleRadios2">
                                                > 1 Tahun
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row card-header mt-4"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Lainya -->
<div class="modal fade" id="modalAnalisis" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-danger mt-2 mr-2 float-right close-data-detail-pasien" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-9">
                    <h5 class="judul-detail-data-pasien pb-2">Analisis dan Rekomendasi</h5>
                </div>
            </div>
            <div class="modal-body pb-0">
                <div class="row justify-content-center">
                    <div class="col-9 shadow-sm p-4">
                        <form action="/dashboard/detail/tambahanalisis/" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="iddatapasien" value="<?= $datapasien['id_data_pasien']; ?>">
                            <div class="form-group">
                                <input type="text" class="form-control inputan-judul-lifestyle bg-light" id="judul-lifestyle" placeholder="Judul ..." name="judul" maxlength="20" required>
                                <small class="text-info text-right">maksimal 20 karakter</small>
                            </div>
                            <div class="form-group">
                                <textarea type="text" class="form-control inputan-pesan-lifestyle bg-light" id="judul-lifestyle" placeholder="Pesan ..." name="noteanalisis" maxlength="50" required></textarea>
                                <small class="text-info text-right">maksimal 50 karakter</small>
                            </div>
                            <button type="submit" class="btn float-right btn-warna-orange">kirim</button>
                        </form>
                    </div>
                </div>
                <div class="row card-header mt-4"></div>
            </div>
        </div>
    </div>
</div>

<script src="/grafik/highcharts.js"></script>
<script src="/grafik/exporting.js"></script>
<script src="/grafik/export-data.js"></script>
<script src="/grafik/accessibility.js"></script>

<?php
$sistole = array();
$diastole = array();
$cekke = array();
$temcek = 1;
foreach ($datatekanandarah as $dt) {
    $diastole[] = intval($dt['diastole']);
    $sistole[] = intval($dt['sistole']);
    $cekke[] = $temcek;
    $temcek++;
}
?>

<script>
    Highcharts.chart('grafik_tekanan_darah', {

        title: {
            text: 'Data Tekanan Darah'
        },

        subtitle: {
            text: 'Bulan Juli'
        },

        yAxis: {
            title: {
                text: 'Tekanan Darah'
            }
        },

        xAxis: {
            categories: <?= json_encode($cekke); ?>
        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        series: [{
            name: 'Sistolik',
            data: <?= json_encode($sistole); ?>
        }, {
            name: 'Diastolik',
            data: <?= json_encode($diastole); ?>
        }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }

    });
</script>

<?= $this->endSection(); ?>