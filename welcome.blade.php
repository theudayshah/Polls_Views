<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PollCraft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
        }

        .navbar {
            background-color: #343a40;
            padding: 15px 0;
        }

        .navbar .navbar-brand {
            color: #ffffff;
            font-size: 1.6rem;
            font-weight: bold;
        }

        .navbar .nav-item .btn {
            border-radius: 30px;
            font-weight: 500;
        }

        .hero-section {
            background: url('https://picsum.photos/1920/1080?random=1') center center no-repeat;
            background-size: cover;
            color: white;
            text-align: center;
            padding: 150px 0;
            position: relative;
        }

        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: bold;
            text-shadow: 2px 2px 15px rgba(0, 0, 0, 0.7);
        }

        .hero-section p {
            font-size: 1.3rem;
            margin-bottom: 20px;
        }

        .btn-hero {
            font-size: 1.2rem;
            padding: 12px 35px;
            background-color: #007bff;
            color: white;
            border-radius: 30px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-hero:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .category-card {
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .category-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .category-card-body {
            background-color: #ffffff;
            padding: 20px;
            text-align: center;
            border-radius: 0 0 15px 15px;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .footer {
            background-color: #343a40;
            color: white;
            padding: 40px 0;
            text-align: center;
        }

        .footer a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 500;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <span class="navbar-brand">PollCraft</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="btn btn-outline-light me-2 px-4" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-light px-4" href="{{ route('register') }}">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="hero-content">
            <h1>Welcome to PollCraft</h1>
            <p>Engage in exciting polls and share your thoughts with the world!</p>
            <a href="{{ route('login') }}" class="btn btn-hero">Explore Categories</a>
        </div>
    </section>

    <section id="categories" class="container mt-5">
        <h2 class="text-center mb-4 fw-bold text-primary">Explore Popular Poll Categories</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="category-card shadow-lg">
                    <img src="https://picsum.photos/350/200?random=5" class="card-img-top" alt="Tech Polls">
                    <div class="category-card-body">
                        <h5 class="card-title fw-bold">Tech Polls</h5>
                        <p class="card-text">Join discussions about the latest technology trends and gadgets.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="category-card shadow-lg">
                    <img src="https://picsum.photos/350/200?random=6" class="card-img-top" alt="Lifestyle Polls">
                    <div class="category-card-body">
                        <h5 class="card-title fw-bold">Lifestyle Polls</h5>
                        <p class="card-text">Discover trending topics in lifestyle, fashion, and wellness.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="category-card shadow-lg">
                    <img src="https://picsum.photos/350/200?random=7" class="card-img-top" alt="Entertainment Polls">
                    <div class="category-card-body">
                        <h5 class="card-title fw-bold">Entertainment Polls</h5>
                        <p class="card-text">From movies to music, share your thoughts on all things entertainment.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer mt-5">
        <div>
            <p>&copy; 2025 PollCraft. All Rights Reserved.</p>
            <div>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms & Conditions</a>
                <a href="#">Help</a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
