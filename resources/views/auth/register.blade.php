<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Nestica</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #FDFBF0;
            color: #4A3B32;
        }

        /* Header Styles */
        .top-bar {
            background-color: #7E991E;
            color: #483A2E;
            text-align: center;
            padding: 5px;
            font-size: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .header-main {
            background-color: #FDFBF0;
            padding: 20px 50px;
            margin-top: 28px;
        }

        .logo {
            font-size: 36px;
            font-weight: 800;
            color: #4A3B32;
        }

        .banner {
            background-color: #A5A58D;
            /* Ganti 'images/banner.jpg' dengan nama file gambar Anda yang ada di folder public/images */
            background-image: url("{{ asset('images/banner.PNG') }}");
            background-size: cover; /* Mengatur gambar agar memenuhi area */
            background-position: center; /* Mengatur posisi gambar di tengah */
            height: 150px;
            display: flex;
            align-items: center;
            padding-left: 80px;
            padding-top: 20px;
            position: relative;
            overflow: hidden;
            color: #fff;
        }
        
        .banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.3);
        }

        .banner h1 {
            font-size: 36px;
            font-weight: 700;
            color: #e3e3e3ff;
            position: relative;
            z-index: 1;
            text-shadow: 
                -1px -1px 0 #493A2E,
                1px -1px 0 #493A2E,
                -1px 1px 0 #493A2E,
                1px 1px 0 #493A2E,
                2px 2px 4px rgba(0,0,0,0.7);
        }

        /* Form Styles */
        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .section-title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            margin-top: 40px;
            color: #4A3B32;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #8D8D8D;
            background-color: #FDFBF0;
            border-radius: 0;
            font-size: 14px;
        }

        .form-control:focus {
            outline: none;
            border-color: #4A3B32;
        }

        .row {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }

        .col {
            flex: 1;
        }

        .file-input-wrapper {
            position: relative;
            border: 1px solid #8D8D8D;
            padding: 5px;
            background: #FDFBF0;
            display: flex;
            align-items: center;
        }

        .file-input-wrapper input[type=file] {
            width: 100%;
            font-size: 12px;
        }

        .file-placeholder {
            color: #9CA3AF;
        }

        /* Select2 Customization to match theme */
        .select2-container .select2-selection--single {
            height: 38px !important;
            border: 1px solid #8D8D8D !important;
            background-color: #FDFBF0 !important;
            border-radius: 0 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px !important;
            color: #4A3B32 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px !important;
        }

        /* Buttons */
        .btn-group {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
            margin-bottom: 60px;
        }

        .btn {
            padding: 10px 40px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            min-width: 120px;
        }

        .btn-primary {
            background-color: #4A3B32;
            color: #FDFBF0;
        }

        .btn-primary:hover {
            background-color: #3a2e27;
        }

        .btn-secondary {
            background-color: #4A3B32;
            color: #FDFBF0;
        }

        .btn-secondary:hover {
            background-color: #3a2e27;
        }

        /* Footer */
        footer {
            background-color: #4A3B32;
            color: #FDFBF0;
            padding: 40px 50px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .footer-left h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .footer-left p {
            font-size: 12px;
            line-height: 1.5;
        }

        .footer-right {
            text-align: right;
            font-size: 12px;
        }

        /* Error messages */
        .text-danger {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
        }
        
        .alert {
            padding: 15px;
            background-color: #f8d7da;
            color: #721c24;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

    <div class="top-bar">
        BRINGS WARMTH AND CHARACTER INTO EVERY CORNER OF YOUR HOME.
    </div>

    <div class="header-main">
        <div class="logo">Nestica</div>
    </div>

    <div class="banner">
        <h1>Register</h1>
    </div>

    <div class="container">
        @if ($errors->any())
            <div class="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/register') }}" enctype="multipart/form-data">
            @csrf

            <!-- Store Details -->
            <h2 class="section-title">Store Details</h2>
            
            <div class="form-group">
                <label>Store Name</label>
                <input type="text" name="store_name" class="form-control" value="{{ old('store_name') }}" required>
            </div>

            <div class="form-group">
                <label>Descriptions</label>
                <input type="text" name="store_description" class="form-control" value="{{ old('store_description') }}" required>
            </div>

            <!-- Contact Details -->
            <h2 class="section-title">Contact Details</h2>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="owner_name" class="form-control" value="{{ old('owner_name') }}" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>National Identity Number</label>
                        <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" maxlength="16" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Identity Card</label>
                        <div class="file-input-wrapper">
                            <input type="file" name="file_ktp_pic" accept="image/*,application/pdf" required>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Picture</label>
                        <div class="file-input-wrapper">
                            <input type="file" name="foto_ktp_pic" accept="image/*" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address -->
            <h2 class="section-title">Address</h2>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Address Name</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>RT / RW</label>
                        <div style="display: flex; gap: 10px;">
                            <select name="rt" id="rt" class="select2" style="width: 50%;" required>
                                <option value="">RT</option>
                            </select>
                            <select name="rw" id="rw" class="select2" style="width: 50%;" required>
                                <option value="">RW</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Province</label>
                        <select name="province" id="province" class="select2" style="width: 100%;" required>
                            <option value="">Select Province</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>City (Kabupaten/Kota)</label>
                        <select name="city" id="city" class="select2" style="width: 100%;" required disabled>
                            <option value="">Select City</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Country (Kecamatan)</label>
                        <select name="subdistrict" id="subdistrict" class="select2" style="width: 100%;" required disabled>
                            <option value="">Select Kecamatan</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>State (Kelurahan)</label>
                        <select name="kelurahan" id="kelurahan" class="select2" style="width: 100%;" required disabled>
                            <option value="">Select Kelurahan</option>
                        </select>
                    </div>
                </div>
            </div>


            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Apply</button>
                <a href="{{ url('/login') }}" class="btn btn-secondary" style="text-decoration: none; text-align: center; padding-top: 12px;">Cancel</a>
            </div>

        </form>
    </div>

    <footer>
        <div class="footer-left">
            <h3>Nestica</h3>
            <p>(+62) 123 144 567<br>info@nestica.com</p>
        </div>
        <div class="footer-right">
            <p>&copy; 2025 Nestica<br>Made with love by kelompok 4</p>
        </div>
    </footer>

    <script>
        $(document).ready(function() {
            $('.select2').select2();

            // Populate RT and RW dropdowns
            for (let i = 1; i <= 200; i++) {
                let num = i.toString().padStart(3, '0');
                $('#rt').append(new Option(num, num));
                $('#rw').append(new Option(num, num));
            }

            // Load Provinces
            $.get('/api/regions/provinces', function(data) {
                var provinceSelect = $('#province');
                $.each(data, function(index, province) {
                    provinceSelect.append($('<option>', {
                        value: province.name,
                        text: province.name,
                        'data-code': province.code
                    }));
                });
            });

            // Handle Province Change
            $('#province').on('change', function() {
                var code = $(this).find(':selected').data('code');
                var citySelect = $('#city');
                var districtSelect = $('#subdistrict');
                var villageSelect = $('#kelurahan');
                
                citySelect.empty().append('<option value="">Select City</option>').prop('disabled', true);
                districtSelect.empty().append('<option value="">Select Kecamatan</option>').prop('disabled', true);
                villageSelect.empty().append('<option value="">Select Kelurahan</option>').prop('disabled', true);
                
                if (code) {
                    $.get('/api/regions/regencies/' + code, function(data) {
                        $.each(data, function(index, city) {
                            citySelect.append($('<option>', {
                                value: city.name,
                                text: city.name,
                                'data-code': city.code
                            }));
                        });
                        citySelect.prop('disabled', false);
                    });
                }
            });

            // Handle City Change
            $('#city').on('change', function() {
                var code = $(this).find(':selected').data('code');
                var districtSelect = $('#subdistrict');
                var villageSelect = $('#kelurahan');
                
                districtSelect.empty().append('<option value="">Select Kecamatan</option>').prop('disabled', true);
                villageSelect.empty().append('<option value="">Select Kelurahan</option>').prop('disabled', true);
                
                if (code) {
                    $.get('/api/regions/districts/' + code, function(data) {
                        $.each(data, function(index, district) {
                            districtSelect.append($('<option>', {
                                value: district.name,
                                text: district.name,
                                'data-code': district.code
                            }));
                        });
                        districtSelect.prop('disabled', false);
                    });
                }
            });

            // Handle District Change
            $('#subdistrict').on('change', function() {
                var code = $(this).find(':selected').data('code');
                var villageSelect = $('#kelurahan');
                
                villageSelect.empty().append('<option value="">Select Kelurahan</option>').prop('disabled', true);
                
                if (code) {
                    $.get('/api/regions/villages/' + code, function(data) {
                        $.each(data, function(index, village) {
                            villageSelect.append($('<option>', {
                                value: village.name,
                                text: village.name,
                                'data-code': village.code
                            }));
                        });
                        villageSelect.prop('disabled', false);
                    });
                }
            });
        });
    </script>
</body>
</html>
