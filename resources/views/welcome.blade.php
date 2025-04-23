<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Poliklinik Sehat - Pelayanan Kesehatan Terpercaya</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-color: #2d8cf0;
      --secondary-color: #5ebd3e;
      --dark-color: #333;
      --light-color: #f9f9f9;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      line-height: 1.6;
      color: var(--dark-color);
    }
    
    .navbar {
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      padding: 15px 0;
      background-color: white;
    }
    
    .navbar-brand {
      font-weight: 700;
      font-size: 24px;
      color: var(--primary-color);
    }
    
    .navbar-brand span {
      color: var(--secondary-color);
    }
    
    .nav-link {
      font-weight: 500;
      margin: 0 10px;
      transition: all 0.3s ease;
    }
    
    .btn-primary-custom {
      background-color: var(--primary-color);
      color: white;
      border-radius: 50px;
      padding: 8px 20px;
      font-weight: 500;
      transition: all 0.3s ease;
      border: none;
    }
    
    .btn-primary-custom:hover {
      background-color: #2579d8;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      color: white;
    }
    
    .btn-outline-custom {
      background-color: transparent;
      color: var(--primary-color);
      border: 2px solid var(--primary-color);
      border-radius: 50px;
      padding: 8px 20px;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    .btn-outline-custom:hover {
      background-color: var(--primary-color);
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .hero {
      padding: 100px 0;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      position: relative;
      overflow: hidden;
    }
    
    .hero-title {
      font-size: 48px;
      font-weight: 700;
      margin-bottom: 20px;
      color: var(--primary-color);
    }
    
    .hero-subtitle {
      font-size: 18px;
      font-weight: 400;
      margin-bottom: 30px;
      color: #666;
    }
    
    .hero-image {
      max-width: 100%;
      animation: float 4s ease-in-out infinite;
    }
    
    @keyframes float {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-20px); }
      100% { transform: translateY(0px); }
    }
    
    .feature-box {
      background-color: white;
      border-radius: 15px;
      padding: 30px;
      text-align: center;
      box-shadow: 0 10px 30px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
      height: 100%;
    }
    
    .feature-box:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }
    
    .feature-icon {
      font-size: 40px;
      margin-bottom: 20px;
      color: var(--primary-color);
    }
    
    .section-title {
      font-size: 36px;
      font-weight: 700;
      margin-bottom: 50px;
      text-align: center;
      color: var(--primary-color);
    }
    
    .doctor-card {
      background-color: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
      height: 100%;
    }
    
    .doctor-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }
    
    .doctor-image {
      width: 100%;
      height: 250px;
      object-fit: cover;
    }
    
    .doctor-info {
      padding: 20px;
    }
    
    .doctor-name {
      font-size: 22px;
      font-weight: 600;
      margin-bottom: 5px;
    }
    
    .doctor-specialty {
      font-size: 16px;
      color: var(--primary-color);
      margin-bottom: 15px;
    }
    
    .testimonial-card {
      background-color: white;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
      height: 100%;
      position: relative;
    }
    
    .testimonial-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }
    
    .testimonial-card::before {
      content: '\201C';
      font-size: 80px;
      position: absolute;
      top: -10px;
      left: 20px;
      color: var(--primary-color);
      opacity: 0.1;
    }
    
    .footer {
      background-color: #333;
      color: white;
      padding: 50px 0 20px;
    }
    
    .footer-title {
      font-size: 20px;
      font-weight: 600;
      margin-bottom: 20px;
      color: white;
    }
    
    .footer-links {
      list-style: none;
      padding: 0;
    }
    
    .footer-links li {
      margin-bottom: 10px;
    }
    
    .footer-links a {
      color: #ccc;
      text-decoration: none;
      transition: all 0.3s ease;
    }
    
    .footer-links a:hover {
      color: var(--primary-color);
      padding-left: 5px;
    }
    
    @media (max-width: 768px) {
      .hero {
        padding: 80px 0;
        text-align: center;
      }
      
      .hero-title {
        font-size: 36px;
      }
      
      .hero-subtitle {
        font-size: 16px;
      }
      
      .hero-image {
        margin-top: 50px;
      }
      
      .section-title {
        font-size: 30px;
      }
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
      <a class="navbar-brand" href="#">Poli<span>klinik</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="#home">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#features">Layanan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#doctors">Dokter</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#testimonials">Testimoni</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contact">Kontak</a>
          </li>
        </ul>
        <div class="ms-auto">
          @if (Route::has('login'))
            @auth
              <a href="{{ url('/home') }}" class="btn btn-primary-custom">Dashboard</a>
            @else
              <a href="{{ route('login') }}" class="btn btn-primary-custom me-2">Masuk</a>
              @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-outline-custom">Daftar</a>
              @endif
            @endauth
          @endif
        </div>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero" id="home">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <h1 class="hero-title">Pelayanan Kesehatan Terpercaya</h1>
          <p class="hero-subtitle">Poliklinik Sehat hadir untuk memberikan pelayanan kesehatan terbaik dengan dokter-dokter berpengalaman dan fasilitas modern.</p>
          <div class="d-flex gap-3">
            @if (Route::has('login'))
              @auth
                <a href="{{ url('/home') }}" class="btn btn-primary-custom btn-lg">Dashboard</a>
              @else
                <a href="{{ route('login') }}" class="btn btn-primary-custom btn-lg">Masuk</a>
                @if (Route::has('register'))
                  <a href="{{ route('register') }}" class="btn btn-outline-custom btn-lg">Daftar Sekarang</a>
                @endif
              @endauth
            @endif
          </div>
        </div>
        <div class="col-lg-6">
          <img src="https://img.freepik.com/free-vector/medical-healthcare-services-concept_1200-155.jpg" alt="Healthcare Illustration" class="hero-image">
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="py-5 my-5" id="features">
    <div class="container">
      <h2 class="section-title">Layanan Kami</h2>
      <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="feature-box">
            <i class="fas fa-stethoscope feature-icon"></i>
            <h3>Pemeriksaan Umum</h3>
            <p>Layanan pemeriksaan kesehatan umum oleh dokter-dokter berpengalaman untuk menangani berbagai keluhan kesehatan.</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="feature-box">
            <i class="fas fa-heartbeat feature-icon"></i>
            <h3>Pemeriksaan Khusus</h3>
            <p>Layanan pemeriksaan spesialis untuk kondisi kesehatan tertentu dengan peralatan modern dan terkini.</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="feature-box">
            <i class="fas fa-pills feature-icon"></i>
            <h3>Farmasi</h3>
            <p>Layanan apotek yang menyediakan obat-obatan berkualitas dengan harga terjangkau dan konsultasi penggunaan obat.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Doctors Section -->
  <section class="py-5 my-5 bg-light" id="doctors">
    <div class="container">
      <h2 class="section-title">Dokter Kami</h2>
      <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="doctor-card">
            <img src="https://img.freepik.com/free-photo/portrait-smiling-handsome-male-doctor-man_171337-5055.jpg" alt="Dr. Andi Pratama" class="doctor-image">
            <div class="doctor-info">
              <h3 class="doctor-name">Dr. Andi Pratama</h3>
              <p class="doctor-specialty">Dokter Umum</p>
              <p>Dokter umum berpengalaman dengan lebih dari 10 tahun praktik dalam menangani berbagai kondisi kesehatan.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="doctor-card">
            <img src="https://img.freepik.com/free-photo/doctor-with-his-arms-crossed-white-background_1368-5790.jpg" alt="Dr. Budi Santoso" class="doctor-image">
            <div class="doctor-info">
              <h3 class="doctor-name">Dr. Budi Santoso</h3>
              <p class="doctor-specialty">Dokter Umum</p>
              <p>Dokter umum dengan pendekatan yang teliti dan santai, membuat pasien merasa nyaman saat konsultasi.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="doctor-card">
            <img src="https://img.freepik.com/free-photo/woman-doctor-wearing-lab-coat-with-stethoscope-isolated_1303-29791.jpg" alt="Dr. Dewi Sartika" class="doctor-image">
            <div class="doctor-info">
              <h3 class="doctor-name">Dr. Dewi Sartika</h3>
              <p class="doctor-specialty">Dokter Umum</p>
              <p>Dokter dengan pendekatan yang ramah dan teliti dalam menangani pasien dari berbagai kalangan usia.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section class="py-5 my-5" id="testimonials">
    <div class="container">
      <h2 class="section-title">Testimoni Pasien</h2>
      <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="testimonial-card">
            <p>"Pelayanan di Poliklinik Sehat sangat baik dan profesional. Dokternya ramah dan menjelaskan kondisi saya dengan detail. Saya merasa lebih tenang setelah berobat di sini."</p>
            <div class="d-flex align-items-center mt-3">
              <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Ahmad Fadli" class="rounded-circle me-3" width="50">
              <div>
                <h5 class="mb-0">Ahmad Fadli</h5>
                <small class="text-muted">Pasien</small>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="testimonial-card">
            <p>"Fasilitas di Poliklinik Sehat sangat lengkap dan modern. Prosedur pendaftaran juga mudah dan tidak membutuhkan waktu lama. Dokternya sangat kompeten."</p>
            <div class="d-flex align-items-center mt-3">
              <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Siti Aminah" class="rounded-circle me-3" width="50">
              <div>
                <h5 class="mb-0">Siti Aminah</h5>
                <small class="text-muted">Pasien</small>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="testimonial-card">
            <p>"Anak saya selalu merasa nyaman setiap kali berobat di Poliklinik Sehat. Dokter anaknya sangat sabar dan pintar membuat anak-anak tidak takut untuk diperiksa."</p>
            <div class="d-flex align-items-center mt-3">
              <img src="https://randomuser.me/api/portraits/men/62.jpg" alt="Budi Rahardjo" class="rounded-circle me-3" width="50">
              <div>
                <h5 class="mb-0">Budi Rahardjo</h5>
                <small class="text-muted">Orang Tua Pasien</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section class="py-5 my-5 bg-light" id="contact">
    <div class="container">
      <h2 class="section-title">Hubungi Kami</h2>
      <div class="row">
        <div class="col-lg-6 mb-4">
          <div class="bg-white p-4 rounded shadow-sm">
            <h4 class="mb-4">Informasi Kontak</h4>
            <div class="d-flex mb-3">
              <div class="me-3">
                <i class="fas fa-map-marker-alt text-primary fa-2x"></i>
              </div>
              <div>
                <h5>Alamat</h5>
                <p>Jl. Kesehatan No. 123, Jakarta Selatan</p>
              </div>
            </div>
            <div class="d-flex mb-3">
              <div class="me-3">
                <i class="fas fa-phone-alt text-primary fa-2x"></i>
              </div>
              <div>
                <h5>Telepon</h5>
                <p>(021) 1234-5678</p>
              </div>
            </div>
            <div class="d-flex mb-3">
              <div class="me-3">
                <i class="fas fa-envelope text-primary fa-2x"></i>
              </div>
              <div>
                <h5>Email</h5>
                <p>info@polikliniksehat.com</p>
              </div>
            </div>
            <div class="d-flex">
              <div class="me-3">
                <i class="fas fa-clock text-primary fa-2x"></i>
              </div>
              <div>
                <h5>Jam Operasional</h5>
                <p>Senin - Sabtu: 08.00 - 20.00<br>Minggu: 09.00 - 14.00</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="bg-white p-4 rounded shadow-sm">
            <h4 class="mb-4">Kirim Pesan</h4>
            <form>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="name" class="form-label">Nama Lengkap</label>
                  <input type="text" class="form-control" id="name" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" required>
                </div>
              </div>
              <div class="mb-3">
                <label for="subject" class="form-label">Subjek</label>
                <input type="text" class="form-control" id="subject" required>
              </div>
              <div class="mb-3">
                <label for="message" class="form-label">Pesan</label>
                <textarea class="form-control" id="message" rows="4" required></textarea>
              </div>
              <button type="submit" class="btn btn-primary-custom">Kirim Pesan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 mb-4">
          <h3 class="mb-3">Poli<span class="text-primary">klinik</span></h3>
          <p>Poliklinik Sehat adalah pusat layanan kesehatan terpercaya yang menyediakan pelayanan medis berkualitas dengan dokter-dokter berpengalaman dan fasilitas modern.</p>
          <div class="d-flex gap-3 mt-3">
            <a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
          </div>
        </div>
        <div class="col-lg-2 col-md-4 mb-4">
          <h5 class="footer-title">Layanan</h5>
          <ul class="footer-links">
            <li><a href="#">Pemeriksaan Umum</a></li>
            <li><a href="#">Pemeriksaan Khusus</a></li>
            <li><a href="#">Farmasi</a></li>
            <li><a href="#">Unit Gawat Darurat</a></li>
            <li><a href="#">Laboratorium</a></li>
          </ul>
        </div>
        <div class="col-lg-2 col-md-4 mb-4">
          <h5 class="footer-title">Link Cepat</h5>
          <ul class="footer-links">
            <li><a href="#home">Beranda</a></li>
            <li><a href="#features">Layanan</a></li>
            <li><a href="#doctors">Dokter</a></li>
            <li><a href="#testimonials">Testimoni</a></li>
            <li><a href="#contact">Kontak</a></li>
          </ul>
        </div>
        <div class="col-lg-4 col-md-4 mb-4">
          <h5 class="footer-title">Jam Praktik</h5>
          <ul class="list-unstyled">
            <li class="mb-2">Senin - Jumat: 08.00 - 20.00</li>
            <li class="mb-2">Sabtu: 08.00 - 17.00</li>
            <li>Minggu: 09.00 - 14.00</li>
          </ul>
          <div class="mt-4">
            <h5 class="footer-title">Nomor Darurat</h5>
            <h4 class="text-white">(021) 1234-5678</h4>
          </div>
        </div>
      </div>
      <div class="text-center pt-4 mt-4 border-top border-secondary">
        <p>&copy; {{ date('Y') }} Poliklinik Sehat. All Rights Reserved.</p>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>