<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8"> <!-- Mendefinisikan set karakter untuk dokumen HTML -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Mengoptimalkan tampilan di Internet Explorer -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> <!-- Mengatur viewport untuk responsif -->
  <meta name="description" content=""> <!-- Deskripsi dari halaman web -->
  <meta name="author" content=""> <!-- Penulis dari halaman web -->
  <link rel="icon" type="image/x-icon" href="<?= base_url() ?>assets/images/favicon.ico"> <!-- Link ke favicon -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"> <!-- Menghubungkan ke Font Awesome -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> <!-- Menghubungkan ke Google Fonts -->
  <link href="<?= base_url() ?>assets/css/sb-admin-2.min.css" rel="stylesheet"> <!-- Menghubungkan ke CSS template -->
  <link href="<?= base_url() ?>assets/DataTables-1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet"> <!-- Menghubungkan ke CSS DataTables -->
  <link href="<?= base_url() ?>assets/Responsive-2.2.2/css/responsive.bootstrap4.min.css" rel="stylesheet"> <!-- Menghubungkan ke CSS responsif untuk DataTables -->
  <link href="<?= base_url() ?>assets/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet"> <!-- Menghubungkan ke CSS jQuery UI -->
  <title>Product Kind</title> <!-- Judul dari halaman web -->
</head>

<body id="page-top">

  <div id="wrapper">
    <?php $this->load->view('component/sidebar') ?> <!-- Memuat sidebar dari komponen -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php $this->load->view('component/header') ?> <!-- Memuat header dari komponen -->
        <div class="container-fluid">

          <?php
          if ($this->session->userdata('create')) {
            echo ('<button class="btn btn-success" onclick="add_kind()"><i class="glyphicon glyphicon-plus"></i>Tambah</button><br><br>'); // Tombol untuk menambah jenis produk
          }
          ?>

          <table id="tabelBarang" class="table table-striped table-bordered nowrap text-center" style="width:100%">
            <thead>
              <tr>
                <th class="text-center">No</th> <!-- Kolom nomor -->
                <th>Jenis</th> <!-- Kolom jenis -->
                <th>Option</th> <!-- Kolom opsi -->
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <?php $this->load->view('component/footer') ?> <!-- Memuat footer dari komponen -->
    </div>
  </div>

  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i> <!-- Ikon untuk scroll ke atas -->
  </a>

  <script src="<?= base_url() ?>assets/jquery/jquery-3.2.1.min.js"></script> <!-- Menghubungkan ke jQuery -->
  <script src="<?= base_url() ?>assets/bootstrap-4.1.3/js/bootstrap.min.js"></script> <!-- Menghubungkan ke Bootstrap JS -->
  <script src="<?= base_url() ?>assets/js/sb-admin-2.js"></script> <!-- Menghubungkan ke JS template -->
  <script src="<?= base_url() ?>assets/DataTables-1.10.18/js/jquery.dataTables.min.js"></script> <!-- Menghubungkan ke JS DataTables -->
  <script src="<?= base_url() ?>assets/DataTables-1.10.18/js/dataTables.bootstrap4.min.js"></script> <!-- Menghubungkan ke JS Bootstrap untuk DataTables -->
  <script src="<?= base_url() ?>assets/Responsive-2.2.2/js/dataTables.responsive.min.js"></script> <!-- Menghubungkan ke JS responsif untuk DataTables -->
  <script src="<?= base_url() ?>assets/Responsive-2.2.2/js/responsive.bootstrap4.min.js"></script> <!-- Menghubungkan ke JS Bootstrap responsif untuk DataTables -->
  <script src="<?php echo base_url() ?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> <!-- Menghubungkan ke JS Bootstrap Datepicker -->
  <script src="<?php echo base_url() ?>assets/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script> <!-- Menghubungkan ke JS jQuery UI -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> <!-- Menghubungkan ke SweetAlert untuk alert yang lebih baik -->

  <script>
    let table;
    let save_method = '';

    $(document).ready(function() {
      $("body").toggleClass("sidebar-toggled"); // Toggle sidebar ketika halaman dimuat
      $(".sidebar").toggleClass("toggled"); // Toggle sidebar ketika halaman dimuat
      find_kind(); // Memanggil fungsi untuk mencari jenis produk
    });

    function find_kind() {
      table = $('#tabelBarang').DataTable({ // Inisialisasi DataTable
        "columnDefs": [{
          "targets": [1, 2],
          "orderable": false, // Membuat kolom jenis dan opsi tidak dapat diurutkan
        }, ],
        
        "order": [],
        "serverSide": true, // Menggunakan server-side processing
        "ajax": {
          "url": "<?= site_url('product_kind/find_kinds') ?>", // URL sumber data
          "type": "POST" // Metode pengiriman data
        },
        "lengthChange": true, // Menonaktifkan kemampuan untuk mengubah jumlah data per halaman
        "responsive": true, // Mengaktifkan responsif tabel
      });
    }

    function reload_table() {
      table.ajax.reload(null, false); // Reload data tabel tanpa mereset paging
    }

    function add_kind() {
      save_method = 'add'; // Set metode simpan sebagai 'add'
      $('#form_kind')[0].reset(); // Reset form pada modal
      $('.modal-title').text('Tambah Jenis'); // Set judul modal
      $('#modal_kind').modal('show'); // Tampilkan modal
    }

    function edit_kind(id) {
      $.ajax({
        url: "<?= site_url('product_kind/find_kind') ?>/" + id, // URL untuk mengambil data jenis produk
        type: "GET", // Metode pengiriman data
        dataType: "JSON", // Tipe data yang diharapkan
        success: function(data) {
          save_method = 'update'; // Set metode simpan sebagai 'update'
          $("#kind_id").val(data.kind_id); // Set id jenis produk di form
          $("#kind_name").val(data.kind_name); // Set nama jenis produk di form
          $("#kindModalLabel").html("Edit Jenis"); // Set judul modal
          $('#modal_kind').modal('show'); // Tampilkan modal
        },
        error: function(err) {
          alert('Error get data from ajax'); // Tampilkan alert error
        }
      });
    }

    function close_modal() {
      $('#modal_kind').modal('hide'); // Sembunyikan modal
    }

    function delete_kind(id) {
      swal({
          title: "Apakah anda yakin?", // Judul konfirmasi
          text: "Data yang dihapus tidak dapat dikembalikan!", // Teks konfirmasi
          icon: "warning", // Ikon peringatan
          buttons: true, // Tampilkan tombol
          dangerMode: true, // Aktifkan mode bahaya
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: "<?= site_url('product_kind/delete_kind') ?>/" + id, // URL untuk menghapus jenis produk
              type: "POST", // Metode pengiriman data
              success: function(data) {
                swal("Jenis produk telah berhasil dihapus", {
                  icon: "success", // Tampilkan ikon sukses
                });
                reload_table(); // Reload tabel
              },
              error: function(err) {
                alert('Error menghapus data'); // Tampilkan alert error
              }
            });
          }
        });
    }

    function store_kind() {
      var url;
      if (save_method === 'add') {
        url = "<?= site_url('product_kind/save_kind') ?>"; // URL untuk menyimpan data baru
      } else {
        url = "<?= site_url('product_kind/update_kind') ?>"; // URL untuk memperbarui data
      }
      $.ajax({
        url: url, // URL yang digunakan
        type: "POST", // Metode pengiriman data
        data: $('#form_kind').serialize(), // Data yang dikirim
        dataType: "JSON", // Tipe data yang diharapkan
        success: function(data) {
          close_modal(); // Tutup modal
          swal("Sukses", {
            icon: "success", // Tampilkan ikon sukses
          });
          reload_table(); // Reload tabel
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('error'); // Tampilkan alert error
        }
      });
    }
  </script>

  <div class="modal fade" id="modal_kind" tabindex="-1" role="dialog" aria-labelledby="kindModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="kindModalLabel"></h5> <!-- Judul modal -->
          <button type="button" class="close" onClick="close_modal()" aria-label="Close">
            <span aria-hidden="true">&times;</span> <!-- Tombol tutup modal -->
          </button>
        </div>
        <div class="modal-body form" style="position: static">
          <div class="container">
            <form id="form_kind">
              <input type="hidden" class="" id="kind_id" name="kind_id"> <!-- Input tersembunyi untuk id jenis produk -->
              <div class="form-group">
                <label for="kind_name" class="col-form-label">Jenis</label> <!-- Label untuk nama jenis produk -->
                <input type="text" class="form-control" id="kind_name" name="kind_name"> <!-- Input untuk nama jenis produk -->
                <div class="invalid-feedback"></div> <!-- Feedback untuk input yang tidak valid -->
              </div>
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" onClick="store_kind()" class="btn btn-primary">Simpan</button> <!-- Tombol simpan -->
        </div>
      </div>
    </div>
  </div>

</body>

</html>