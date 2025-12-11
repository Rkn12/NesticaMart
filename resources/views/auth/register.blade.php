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

        .top-bar {
            background-color: #7E991E;
            color: #FBFDF0;
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
            background-image: url("{{ asset('images/banner.PNG') }}");
            background-size: cover;
            background-position: center;
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

        /* Success Modal */
        .success-modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .success-content {
            background-color: #FDFBF0;
            margin: auto;
            padding: 70px 60px 50px 60px;
            border-radius: 8px;
            width: 90%;
            max-width: 1100px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            font-family: Arial, sans-serif;
            animation: slideIn 0.3s;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        @keyframes slideIn {
            from { transform: translate(-50%, -60%); opacity: 0; }
            to { transform: translate(-50%, -50%); opacity: 1; }
        }

        .close-btn {
            color: #483A2E !important;
            position: absolute;
            right: 25px;
            top: 20px;
            font-size: 60px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            background: none !important;
            padding: 0;
            line-height: 1;
            outline: none;
            z-index: 10;
        }

        .close-btn:hover {
            opacity: 0.7;
        }

        .close-btn:focus {
            outline: none;
            background: none !important;
        }

        .paper-plane-icon {
            width: 80px;
            height: 80px;
            margin-bottom: 25px;
            display: inline-block;
        }

        .paper-plane-icon svg {
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .success-content h3 {
            font-size: 20px;
            font-weight: 600;
            color: #4A3B32;
            margin-bottom: 20px;
            font-family: Arial, sans-serif;
            line-height: 1.4;
        }

        .success-content .verification-text {
            font-size: 14px;
            color: #7E991E;
            line-height: 1.8;
            margin-bottom: 35px;
            font-family: Arial, sans-serif;
        }

        .success-content button {
            padding: 12px 35px;
            background: #4A3B32;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }

        .success-content button:hover {
            background: #3a2e27;
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

        <form id="registerForm" method="POST" action="{{ url('/register') }}" enctype="multipart/form-data">
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
                        <label>No. KTP</label>
                        <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" maxlength="16" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Identity Card (KTP)</label>
                        <div class="file-input-wrapper">
                            <input type="file" name="file_ktp_pic" accept="image/*,application/pdf" required>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Picture (Foto PIC)</label>
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
                        <label>Province (Provinsi)</label>
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
                        <label>District (Kecamatan)</label>
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

    <!-- Success Modal -->
    <div id="successModal" class="success-modal">
        <div class="success-content">
            <button class="close-btn" onclick="closeSuccessModal()" style="color: #483A2E; font-size: 40px; background: none; border: none;">×</button>
            <div class="paper-plane-icon">
                <svg viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg" style="width: 80px; height: 80px;">
                    <circle cx="25" cy="6" r="3" fill="#7E991E"/>
                    <circle cx="25" cy="6" r="3" fill="#7E991E" opacity="0.9" transform="rotate(30 25 25)"/>
                    <circle cx="25" cy="6" r="3" fill="#7E991E" opacity="0.8" transform="rotate(60 25 25)"/>
                    <circle cx="25" cy="6" r="3" fill="#7E991E" opacity="0.7" transform="rotate(90 25 25)"/>
                    <circle cx="25" cy="6" r="3" fill="#7E991E" opacity="0.6" transform="rotate(120 25 25)"/>
                    <circle cx="25" cy="6" r="3" fill="#7E991E" opacity="0.5" transform="rotate(150 25 25)"/>
                    <circle cx="25" cy="6" r="3" fill="#7E991E" opacity="0.4" transform="rotate(180 25 25)"/>
                    <circle cx="25" cy="6" r="3" fill="#7E991E" opacity="0.3" transform="rotate(210 25 25)"/>
                    <circle cx="25" cy="6" r="3" fill="#7E991E" opacity="0.2" transform="rotate(240 25 25)"/>
                    <circle cx="25" cy="6" r="3" fill="#7E991E" opacity="0.15" transform="rotate(270 25 25)"/>
                    <circle cx="25" cy="6" r="3" fill="#7E991E" opacity="0.1" transform="rotate(300 25 25)"/>
                    <circle cx="25" cy="6" r="3" fill="#7E991E" opacity="0.05" transform="rotate(330 25 25)"/>
                </svg>
            </div>
            <h3>Your registration is currently under verification</h3>
            <p class="verification-text">
                The verification result will be sent to your email. Please make sure your email is active.
            </p>
            <button onclick="backToHomepage()">Back to Homepage</button>
        </div>
    </div>

    <script>
        function closeSuccessModal() {
            document.getElementById('successModal').style.display = 'none';
            document.getElementById('registerForm').reset();
            $('.select2').val(null).trigger('change');
            // Reset disabled states
            $('#city, #subdistrict, #kelurahan').prop('disabled', true);
        }

        function backToHomepage() {
            window.location.href = '{{ url("/products") }}';
        }

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

            // Handle form submission with AJAX
            $('#registerForm').on('submit', function(e) {
                e.preventDefault();
                
                var formData = new FormData(this);
                var submitBtn = $(this).find('button[type="submit"]');
                submitBtn.prop('disabled', true).text('Processing...');
                
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        submitBtn.prop('disabled', false).text('Apply');
                        $('#successModal').css('display', 'block');
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).text('Apply');
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMsg = 'Please fix the following errors:\n';
                            $.each(errors, function(key, value) {
                                errorMsg += '- ' + value[0] + '\n';
                            });
                            alert(errorMsg);
                        } else {
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                alert(xhr.responseJSON.message);
                            } else {
                                alert('An error occurred. Please try again.');
                            }
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
