<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Penjual - MartPlace</title>
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
        
        /* Select2 Customization */
        .select2-container .select2-selection--single {
            height: 45px !important;
            border: 1px solid #ddd !important;
            border-radius: 6px !important;
            padding: 8px !important;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 43px !important;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        
        .wizard-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .wizard-header {
            background: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .wizard-header h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .wizard-header p {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .progress-bar {
            display: flex;
            justify-content: space-between;
            padding: 30px 50px;
            background: #f8f9fa;
            position: relative;
        }
        
        .progress-bar::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50px;
            right: 50px;
            height: 2px;
            background: #e0e0e0;
            z-index: 0;
        }
        
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 1;
        }
        
        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: 2px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #999;
            margin-bottom: 8px;
            transition: all 0.3s;
        }
        
        .step.active .step-circle {
            background: #667eea;
            border-color: #667eea;
            color: white;
        }
        
        .step.completed .step-circle {
            background: #27ae60;
            border-color: #27ae60;
            color: white;
        }
        
        .step-label {
            font-size: 12px;
            color: #666;
            text-align: center;
            max-width: 100px;
        }
        
        .step.active .step-label {
            color: #667eea;
            font-weight: 600;
        }
        
        .form-content {
            padding: 40px 50px;
        }
        
        .form-section {
            display: none;
        }
        
        .form-section.active {
            display: block;
        }
        
        .section-title {
            font-size: 20px;
            color: #2c3e50;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .form-row.full {
            grid-template-columns: 1fr;
        }
        
        .form-group {
            margin-bottom: 0;
        }
        
        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 8px;
        }
        
        .form-group label .required {
            color: #e74c3c;
        }
        
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="tel"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        .form-group input[type="file"] {
            padding: 10px;
            border: 2px dashed #ddd;
            border-radius: 6px;
            width: 100%;
            cursor: pointer;
        }
        
        .form-group small {
            display: block;
            margin-top: 5px;
            color: #666;
            font-size: 12px;
        }
        
        .error-message {
            display: block;
            margin-top: 5px;
            color: #e74c3c;
            font-size: 12px;
            font-weight: 500;
        }
        
        .form-group input.error,
        .form-group textarea.error {
            border-color: #e74c3c;
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
        }
        
        .form-group input.valid,
        .form-group textarea.valid {
            border-color: #27ae60;
            box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1);
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        
        .alert-danger {
            background: #fee;
            border: 1px solid #fcc;
            color: #c00;
        }
        
        .alert ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .wizard-actions {
            display: flex;
            justify-content: space-between;
            padding: 30px 50px;
            background: #f8f9fa;
            border-top: 1px solid #e0e0e0;
        }
        
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-secondary {
            background: #95a5a6;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #7f8c8d;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .text-center {
            text-align: center;
            margin-top: 20px;
        }
        
        .text-center a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        
        .text-center a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="wizard-container">
        <div class="wizard-header">
            <h1>Registrasi Sebagai Penjual</h1>
            <p>Lengkapi data berikut untuk mendaftar sebagai penjual di platform kami</p>
        </div>
        
        <div class="progress-bar">
            <div class="step active" data-step="1">
                <div class="step-circle">1</div>
                <div class="step-label">Data Toko</div>
            </div>
            <div class="step" data-step="2">
                <div class="step-circle">2</div>
                <div class="step-label">Data Pemilik</div>
            </div>
            <div class="step" data-step="3">
                <div class="step-circle">3</div>
                <div class="step-label">Alamat</div>
            </div>
        </div>
        
        @if ($errors->any())
            <div style="padding: 0 50px; padding-top: 20px;">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        
        <form method="POST" action="{{ url('/register') }}" enctype="multipart/form-data" id="registrationForm">
            @csrf
            
            <div class="form-content">
                <!-- Step 1: Data Toko -->
                <div class="form-section active" data-section="1">
                    <h2 class="section-title">Data Toko</h2>
                    
                    <div class="form-row full">
                        <div class="form-group">
                            <label for="store_name">Nama Toko <span class="required">*</span></label>
                            <input type="text" id="store_name" name="store_name" value="{{ old('store_name') }}" placeholder="Masukkan nama toko Anda" required>
                            <div class="error-message" id="store_name_error" style="display: none;"></div>
                        </div>
                    </div>
                    
                    <div class="form-row full">
                        <div class="form-group">
                            <label for="store_description">Deskripsi Singkat <span class="required">*</span></label>
                            <textarea id="store_description" name="store_description" placeholder="Deskripsikan toko Anda" required>{{ old('store_description') }}</textarea>
                            <div class="error-message" id="store_description_error" style="display: none;"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Step 2: Data PIC -->
                <div class="form-section" data-section="2">
                    <h2 class="section-title">Data PIC Toko</h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="owner_name">Nama PIC <span class="required">*</span></label>
                            <input type="text" id="owner_name" name="owner_name" value="{{ old('owner_name') }}" placeholder="Masukkan nama pemilik" required>
                            <div class="error-message" id="owner_name_error" style="display: none;"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="nik">No. KTP <span class="required">*</span></label>
                            <input type="text" id="nik" name="nik" value="{{ old('nik') }}" placeholder="16 digit NIK" maxlength="16" required>
                            <div class="error-message" id="nik_error" style="display: none;"></div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">No. Handphone <span class="required">*</span></label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="081234567890" required>
                            <div class="error-message" id="phone_error" style="display: none;"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email <span class="required">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" required>
                            <div class="error-message" id="email_error" style="display: none;"></div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="foto_ktp_pic">Foto PIC <span class="required">*</span></label>
                            <input type="file" id="foto_ktp_pic" name="foto_ktp_pic" accept="image/*" required>
                            <small>Format: JPG, PNG, max 2MB</small>
                            <div class="error-message" id="foto_ktp_pic_error" style="display: none;"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="file_ktp_pic">File Upload KTP <span class="required">*</span></label>
                            <input type="file" id="file_ktp_pic" name="file_ktp_pic" accept="image/*,application/pdf" required>
                            <small>Format: JPG, PNG, PDF, max 2MB</small>
                            <div class="error-message" id="file_ktp_pic_error" style="display: none;"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Step 3: Alamat -->
                <div class="form-section" data-section="3">
                    <h2 class="section-title">Alamat</h2>
                    
                    <div class="form-row full">
                        <div class="form-group">
                            <label for="address">Alamat <span class="required">*</span></label>
                            <textarea id="address" name="address" placeholder="Masukkan alamat lengkap" required>{{ old('address') }}</textarea>
                            <div class="error-message" id="address_error" style="display: none;"></div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="province">Provinsi <span class="required">*</span></label>
                            <select id="province" name="province" class="select2" style="width: 100%;" required>
                                <option value="">-- Pilih Provinsi --</option>
                            </select>
                            <div class="error-message" id="province_error" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label for="city">Kabupaten/Kota <span class="required">*</span></label>
                            <select id="city" name="city" class="select2" style="width: 100%;" required disabled>
                                <option value="">-- Pilih Kota/Kabupaten --</option>
                            </select>
                            <div class="error-message" id="city_error" style="display: none;"></div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="subdistrict">Kecamatan <span class="required">*</span></label>
                            <select id="subdistrict" name="subdistrict" class="select2" style="width: 100%;" required disabled>
                                <option value="">-- Pilih Kecamatan --</option>
                            </select>
                            <div class="error-message" id="subdistrict_error" style="display: none;"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="kelurahan">Kelurahan <span class="required">*</span></label>
                            <select id="kelurahan" name="kelurahan" class="select2" style="width: 100%;" required disabled>
                                <option value="">-- Pilih Kelurahan --</option>
                            </select>
                            <div class="error-message" id="kelurahan_error" style="display: none;"></div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="rt">RT <span class="required">*</span></label>
                            <select id="rt" name="rt" class="select2" style="width: 100%;" required>
                                <option value="">-- Pilih RT --</option>
                            </select>
                            <div class="error-message" id="rt_error" style="display: none;"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="rw">RW <span class="required">*</span></label>
                            <select id="rw" name="rw" class="select2" style="width: 100%;" required>
                                <option value="">-- Pilih RW --</option>
                            </select>
                            <div class="error-message" id="rw_error" style="display: none;"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="wizard-actions">
                <button type="button" class="btn btn-secondary" id="prevBtn" style="display: none;">Kembali</button>
                <div style="flex: 1;"></div>
                <button type="button" class="btn btn-primary" id="nextBtn">Selanjutnya</button>
                <button type="submit" class="btn btn-primary" id="submitBtn" style="display: none;">Daftar Sebagai Penjual</button>
            </div>
        </form>
        
        <div class="text-center" style="padding: 20px; border-top: 1px solid #e0e0e0;">
            <p style="margin-bottom: 15px;">Sudah punya akun? <a href="{{ url('/login') }}" style="color: #667eea; font-weight: 600;">Login di sini</a></p>
            <p style="margin-top: 20px;">
                <a href="{{ url('/products') }}" style="color: #95a5a6; text-decoration: none; display: inline-flex; align-items: center; transition: color 0.3s;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" style="margin-right: 5px;">
                        <path d="M19 12H5M12 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </p>
        </div>
    </div>
    
    <style>
        .text-center a:hover {
            color: #667eea !important;
        }
    </style>
    
    <script>
        let currentStep = 1;
        const totalSteps = 3;
        
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const submitBtn = document.getElementById('submitBtn');
        
        function showStep(step) {
            // Hide all sections
            document.querySelectorAll('.form-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Show current section
            document.querySelector(`.form-section[data-section="${step}"]`).classList.add('active');
            
            // Update progress bar
            document.querySelectorAll('.step').forEach((stepEl, index) => {
                const stepNum = index + 1;
                stepEl.classList.remove('active', 'completed');
                
                if (stepNum < step) {
                    stepEl.classList.add('completed');
                } else if (stepNum === step) {
                    stepEl.classList.add('active');
                }
            });
            
            // Update buttons
            prevBtn.style.display = step === 1 ? 'none' : 'inline-block';
            nextBtn.style.display = step === totalSteps ? 'none' : 'inline-block';
            submitBtn.style.display = step === totalSteps ? 'inline-block' : 'none';
            
            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        
        function validateCurrentStep() {
            const currentSection = document.querySelector(`.form-section[data-section="${currentStep}"]`);
            const inputs = currentSection.querySelectorAll('input[required], textarea[required], select[required]');
            let isValid = true;
            
            // Clear all previous error messages and styles
            inputs.forEach(input => {
                const errorElement = document.getElementById(input.id + '_error');
                if (errorElement) {
                    errorElement.style.display = 'none';
                    errorElement.textContent = '';
                }
                input.classList.remove('error', 'valid');
                input.style.borderColor = '';
            });
            
            inputs.forEach(input => {
                const errorElement = document.getElementById(input.id + '_error');
                let errorMessage = '';
                
                if (!input.value.trim()) {
                    errorMessage = `${input.previousElementSibling.textContent.replace(' *', '')} wajib diisi`;
                    isValid = false;
                } else if (input.type === 'email' && !input.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                    errorMessage = 'Format email tidak valid';
                    isValid = false;
                } else if (input.type === 'tel' && !input.value.match(/^[0-9]{10,15}$/)) {
                    errorMessage = 'Nomor handphone harus 10-15 digit angka';
                    isValid = false;
                } else if (input.name === 'nik' && input.value.length !== 16) {
                    errorMessage = 'NIK harus 16 digit angka';
                    isValid = false;
                } else if (input.type === 'file' && !input.files.length) {
                    errorMessage = 'File wajib diunggah';
                    isValid = false;
                }
                
                if (errorMessage && errorElement) {
                    input.classList.add('error');
                    errorElement.textContent = errorMessage;
                    errorElement.style.display = 'block';
                } else if (input.value.trim()) {
                    input.classList.add('valid');
                }
            });
            
            return isValid;
        }
        
        nextBtn.addEventListener('click', () => {
            if (validateCurrentStep()) {
                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                }
            }
            // Removed the alert, errors will show inline
        });
        
        prevBtn.addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });
        
        // Real-time validation feedback
        document.addEventListener('input', (e) => {
            if (e.target.matches('input[required], textarea[required]')) {
                const errorElement = document.getElementById(e.target.id + '_error');
                
                if (e.target.value.trim()) {
                    e.target.classList.remove('error');
                    e.target.classList.add('valid');
                    if (errorElement) {
                        errorElement.style.display = 'none';
                    }
                } else {
                    e.target.classList.remove('valid');
                    e.target.classList.add('error');
                    if (errorElement) {
                        errorElement.textContent = `${e.target.previousElementSibling.textContent.replace(' *', '')} wajib diisi`;
                        errorElement.style.display = 'block';
                    }
                }
            }
        });
        
        // Validate email format real-time
        document.addEventListener('input', (e) => {
            if (e.target.type === 'email') {
                const errorElement = document.getElementById(e.target.id + '_error');
                
                if (e.target.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                    e.target.classList.remove('error');
                    e.target.classList.add('valid');
                    if (errorElement) {
                        errorElement.style.display = 'none';
                    }
                } else if (e.target.value.trim()) {
                    e.target.classList.remove('valid');
                    e.target.classList.add('error');
                    if (errorElement) {
                        errorElement.textContent = 'Format email tidak valid';
                        errorElement.style.display = 'block';
                    }
                }
            }
        });
        
        // Validate phone number real-time
        document.addEventListener('input', (e) => {
            if (e.target.type === 'tel') {
                const errorElement = document.getElementById(e.target.id + '_error');
                
                // Only allow numbers
                e.target.value = e.target.value.replace(/[^0-9]/g, '');
                
                if (e.target.value.match(/^[0-9]{10,15}$/)) {
                    e.target.classList.remove('error');
                    e.target.classList.add('valid');
                    if (errorElement) {
                        errorElement.style.display = 'none';
                    }
                } else if (e.target.value.trim()) {
                    e.target.classList.remove('valid');
                    e.target.classList.add('error');
                    if (errorElement) {
                        errorElement.textContent = 'Nomor handphone harus 10-15 digit angka';
                        errorElement.style.display = 'block';
                    }
                }
            }
        });
        
        // Validate NIK real-time
        document.addEventListener('input', (e) => {
            if (e.target.name === 'nik') {
                const errorElement = document.getElementById(e.target.id + '_error');
                
                // Only allow numbers, max 16 digits
                e.target.value = e.target.value.replace(/[^0-9]/g, '').substring(0, 16);
                
                if (e.target.value.length === 16) {
                    e.target.classList.remove('error');
                    e.target.classList.add('valid');
                    if (errorElement) {
                        errorElement.style.display = 'none';
                    }
                } else if (e.target.value.trim()) {
                    e.target.classList.remove('valid');
                    e.target.classList.add('error');
                    if (errorElement) {
                        errorElement.textContent = 'NIK harus 16 digit angka';
                        errorElement.style.display = 'block';
                    }
                }
            }
        });
        

        // Validate file input real-time
        document.addEventListener('change', (e) => {
            if (e.target.type === 'file') {
                const errorElement = document.getElementById(e.target.id + '_error');
                
                if (e.target.files.length > 0) {
                    e.target.classList.remove('error');
                    e.target.classList.add('valid');
                    if (errorElement) {
                        errorElement.style.display = 'none';
                    }
                } else {
                    e.target.classList.remove('valid');
                    e.target.classList.add('error');
                    if (errorElement) {
                        errorElement.textContent = 'File wajib diunggah';
                        errorElement.style.display = 'block';
                    }
                }
            }
        });
        
        // Initialize
        showStep(currentStep);

        // Initialize Select2
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
                
                citySelect.empty().append('<option value="">-- Pilih Kota/Kabupaten --</option>').prop('disabled', true);
                districtSelect.empty().append('<option value="">-- Pilih Kecamatan --</option>').prop('disabled', true);
                villageSelect.empty().append('<option value="">-- Pilih Kelurahan --</option>').prop('disabled', true);
                
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
                
                districtSelect.empty().append('<option value="">-- Pilih Kecamatan --</option>').prop('disabled', true);
                villageSelect.empty().append('<option value="">-- Pilih Kelurahan --</option>').prop('disabled', true);
                
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
                
                villageSelect.empty().append('<option value="">-- Pilih Kelurahan --</option>').prop('disabled', true);
                
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
