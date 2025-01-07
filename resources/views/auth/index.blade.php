<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Dengan Google</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        .card-background {
            background-image: url('IMG20240422145415.jpg');
            background-size: cover;
            background-position: center;
            padding: 2rem;
            border-radius: 0.5rem;
        }
        .card-content {
            background: rgba(255, 255, 255, 0.8); /* Optional: to make text more readable */
            border-radius: 0.5rem;
            padding: 1rem;
        }
        .kotakluar {
            border: 1px solid #000;
            padding: 10px;
            border-radius: 5px;
        }
        .kotakdalam {
            border: 1px solid #000;
            padding: 5px;
            border-radius: 5px;
            margin-left: 10px;
        }
        @media (max-width: 576px) {
            .kotakluar {
                width: 100%;
                padding: 5px;
            }
            .kotakdalam {
                margin-left: 5px;
                padding: 3px;
            }
            .btn img {
                width: 50px;
            }
            .btn p {
                font-size: 14px;
            }
        }
    </style>
</head>

<body class="bg-light card-background">
    <main class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="col-12 col-md-8 col-lg-6 mx-auto text-center">
            <div class="card-content">
                
                @if (@session('error'))
                <div id="alert" class="alert alert-danger" onclick="this.style.display='none'">
                    {{Session::get('error')}}
                </div>
            @endif 
                <h1>Login</h1>
                <h5>Silakan login dengan Akun Politala</h5>
                <div class="d-flex justify-content-center">
                    <a href='{{ url('auth/redirect') }}' class="btn d-flex align-items-center justify-content-center kotakluar" style="width: 100%; max-width: 350px; padding: 10px;">
                        <img src="https://i0.wp.com/politala.ac.id/wp-content/uploads/2020/06/Logo-warna-baru-PNG.png?resize=1021%2C1024&ssl=1" alt="Logo Politala" width="80px" height="auto" class="img-fluid mb-2">
                        <div class="d-flex align-items-center kotakdalam">
                            <img width="40px" style="margin-bottom: 3px; margin-right: 5px" alt="Google sign-in" src="https://www.salesforceben.com/wp-content/uploads/2021/03/google-logo-icon-PNG-Transparent-Background-2048x2048.png" />
                            <p class="mb-0" style="white-space: nowrap;">Login dengan Politala</p>
                        </div>
                    </a>
                </div>
                
            </div>
        </div>
    </main>
    <script>
        // Make the alert disappear after 5 seconds
        setTimeout(function() {
            var alert = document.getElementById('alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 5000);
    </script>
</body>
</html>
