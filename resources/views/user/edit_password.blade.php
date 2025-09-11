@extends('adminbackend.layouts.master')

@section('main')
<section class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Change Password</h5>
                        </div>
                        <div class="d-flex justify-content-between align-items-center flex-wrap breadcrumb-white">
                            <ul class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="index.html"><i class="feather icon-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#!">Security</a></li>
                                <li class="breadcrumb-item"><a href="#!">Change Password</a></li>
                            </ul>
                            <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-light mt-2 mt-md-0">
                                ← Back to Previous Page
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-lock me-2"></i>Change Your Password
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="post" action="{{ route('password.update') }}" id="passwordForm">
                            @csrf

                            <!-- Current Password -->
                            <div class="form-group mb-4">
                                <label for="current_password" class="form-label">
                                    <i class="fas fa-key me-1"></i>Current Password
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" name="oldpassword" id="current_password" class="form-control password-field" placeholder="Enter your current password" required>
                                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="current_password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('oldpassword')
                                    <div class="text-danger small mt-1">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="form-group mb-4">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-1"></i>New Password
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control password-field" placeholder="Enter your new password" required>
                                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>

                                <!-- Password Strength Meter -->
                                <div class="password-strength mt-2">
                                    <div class="progress mb-2" style="height: 8px;">
                                        <div id="password-strength-bar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <div id="password-strength-text" class="small text-muted">
                                        Password strength: None
                                    </div>
                                </div>

                                <!-- Password Requirements -->
                                <div class="password-requirements mt-2">
                                    <small class="text-muted">Password must contain:</small>
                                    <ul class="list-unstyled mb-0 small">
                                        <li id="req-length" class="text-danger">
                                            <i class="fas fa-times-circle me-1"></i>At least 8 characters
                                        </li>
                                        <li id="req-uppercase" class="text-danger">
                                            <i class="fas fa-times-circle me-1"></i>One uppercase letter
                                        </li>
                                        <li id="req-lowercase" class="text-danger">
                                            <i class="fas fa-times-circle me-1"></i>One lowercase letter
                                        </li>
                                        <li id="req-number" class="text-danger">
                                            <i class="fas fa-times-circle me-1"></i>One number
                                        </li>
                                        <li id="req-special" class="text-danger">
                                            <i class="fas fa-times-circle me-1"></i>One special character
                                        </li>
                                    </ul>
                                </div>

                                @error('password')
                                    <div class="text-danger small mt-1">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group mb-4">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-lock me-1"></i>Confirm New Password
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control password-field" placeholder="Confirm your new password" required>
                                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password_confirmation">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div id="password-match" class="small mt-1"></div>
                                @error('password_confirmation')
                                    <div class="text-danger small mt-1">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary me-md-2">
                                    <i class="fas fa-times me-1"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="fas fa-save me-1"></i>Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    .password-requirements li.valid {
        color: #28a745 !important;
    }
    .password-requirements li.text-danger {
        color: #dc3545 !important;
    }
    .match {
        color: #28a745 !important;
        font-weight: bold;
    }
    .no-match {
        color: #dc3545 !important;
        font-weight: bold;
    }
    .toggle-password {
        cursor: pointer;
    }
    .progress-bar {
        transition: width 0.3s ease;
    }
</style>
@endsection

@section('scripts')
<script>
    // Wait for the document to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Document loaded, initializing password features...');
        
        // Initialize all functionality
        initPasswordToggle();
        initPasswordStrengthChecker();
        initPasswordMatchChecker();
        initFormValidation();
        
        // Focus on first input
        document.getElementById('current_password')?.focus();
    });

    function initPasswordToggle() {
        console.log('Initializing password toggle...');
        const toggleButtons = document.querySelectorAll('.toggle-password');
        
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const targetInput = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                if (targetInput && icon) {
                    if (targetInput.type === 'password') {
                        targetInput.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        targetInput.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                }
            });
        });
        
        console.log('Password toggle buttons found:', toggleButtons.length);
    }

    function initPasswordStrengthChecker() {
        const passwordInput = document.getElementById('password');
        if (!passwordInput) {
            console.error('Password input not found');
            return;
        }

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            updatePasswordStrength(password);
            updatePasswordRequirements(password);
        });
    }

    function updatePasswordStrength(password) {
        const strengthBar = document.getElementById('password-strength-bar');
        const strengthText = document.getElementById('password-strength-text');
        
        if (!strengthBar || !strengthText) return;

        let strength = 0;
        let message = 'None';
        let color = '#dc3545';

        // Check various strength factors
        if (password.length >= 8) strength += 20;
        if (/[a-z]/.test(password)) strength += 20;
        if (/[A-Z]/.test(password)) strength += 20;
        if (/\d/.test(password)) strength += 20;
        if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength += 20;

        // Determine strength level
        if (strength >= 100) {
            message = 'Strong';
            color = '#28a745';
        } else if (strength >= 80) {
            message = 'Good';
            color = '#ffc107';
        } else if (strength >= 60) {
            message = 'Fair';
            color = '#fd7e14';
        } else if (strength >= 20) {
            message = 'Weak';
            color = '#dc3545';
        }

        // Update UI
        strengthBar.style.width = strength + '%';
        strengthBar.style.backgroundColor = color;
        strengthText.textContent = 'Password strength: ' + message;
        strengthText.style.color = color;
    }

    function updatePasswordRequirements(password) {
        const requirements = {
            'length': password.length >= 8,
            'uppercase': /[A-Z]/.test(password),
            'lowercase': /[a-z]/.test(password),
            'number': /\d/.test(password),
            'special': /[!@#$%^&*(),.?":{}|<>]/.test(password)
        };

        for (const [key, met] of Object.entries(requirements)) {
            const element = document.getElementById('req-' + key);
            if (element) {
                if (met) {
                    element.classList.add('valid');
                    element.classList.remove('text-danger');
                    element.innerHTML = '<i class="fas fa-check-circle me-1"></i>' + element.textContent.replace('*', '');
                } else {
                    element.classList.remove('valid');
                    element.classList.add('text-danger');
                    element.innerHTML = '<i class="fas fa-times-circle me-1"></i>' + element.textContent;
                }
            }
        }
    }

    function initPasswordMatchChecker() {
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const matchText = document.getElementById('password-match');

        if (!passwordInput || !confirmInput || !matchText) return;

        function checkMatch() {
            const password = passwordInput.value;
            const confirm = confirmInput.value;

            if (confirm === '') {
                matchText.textContent = '';
                matchText.className = '';
            } else if (password === confirm) {
                matchText.textContent = '✓ Passwords match';
                matchText.className = 'match';
            } else {
                matchText.textContent = '✗ Passwords do not match';
                matchText.className = 'no-match';
            }
        }

        passwordInput.addEventListener('input', checkMatch);
        confirmInput.addEventListener('input', checkMatch);
    }

    function initFormValidation() {
        const form = document.getElementById('passwordForm');
        if (!form) return;

        form.addEventListener('submit', function(e) {
            const password = document.getElementById('password')?.value;
            const confirm = document.getElementById('password_confirmation')?.value;

            if (password !== confirm) {
                e.preventDefault();
                alert('Error: Passwords do not match. Please make sure both password fields are identical.');
                return false;
            }

            return true;
        });
    }

    // Fallback: If DOMContentLoaded doesn't fire, try to initialize when window loads
    window.addEventListener('load', function() {
        if (!document.querySelector('.toggle-password')) {
            console.log('Window loaded, re-initializing...');
            initPasswordToggle();
            initPasswordStrengthChecker();
            initPasswordMatchChecker();
            initFormValidation();
        }
    });
</script>

@section('scripts')
<script>
    console.log('=== PASSWORD SCRIPT LOADING ===');
    
    // Debug: Check if jQuery is available
    console.log('jQuery available:', typeof jQuery !== 'undefined');
    console.log('Bootstrap available:', typeof bootstrap !== 'undefined');
    
    // Debug: Check if elements exist
    function debugElements() {
        const elements = [
            'current_password', 'password', 'password_confirmation',
            'password-strength-bar', 'password-strength-text',
            'password-match', 'passwordForm'
        ];
        
        elements.forEach(id => {
            const el = document.getElementById(id);
            console.log(`Element #${id}:`, el ? 'FOUND' : 'NOT FOUND');
        });
        
        const toggleButtons = document.querySelectorAll('.toggle-password');
        console.log('Toggle buttons found:', toggleButtons.length);
    }

    // Wait for the document to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('=== DOM CONTENT LOADED ===');
        debugElements();
        
        try {
            console.log('Initializing password features...');
            
            // Initialize all functionality
            initPasswordToggle();
            initPasswordStrengthChecker();
            initPasswordMatchChecker();
            initFormValidation();
            
            // Focus on first input
            const firstInput = document.getElementById('current_password');
            if (firstInput) {
                firstInput.focus();
                console.log('Focused on current_password input');
            }
            
            console.log('All features initialized successfully');
        } catch (error) {
            console.error('Error during initialization:', error);
        }
    });

    function initPasswordToggle() {
        console.log('=== INIT PASSWORD TOGGLE ===');
        const toggleButtons = document.querySelectorAll('.toggle-password');
        console.log('Toggle buttons:', toggleButtons.length);
        
        toggleButtons.forEach((button, index) => {
            console.log(`Button ${index}:`, button);
            console.log(`Button ${index} data-target:`, button.getAttribute('data-target'));
            
            button.addEventListener('click', function() {
                console.log('Toggle button clicked');
                const targetId = this.getAttribute('data-target');
                console.log('Target ID:', targetId);
                
                const targetInput = document.getElementById(targetId);
                console.log('Target input:', targetInput);
                
                const icon = this.querySelector('i');
                console.log('Icon:', icon);
                
                if (targetInput && icon) {
                    console.log('Before toggle - type:', targetInput.type);
                    
                    if (targetInput.type === 'password') {
                        targetInput.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                        console.log('Changed to text type');
                    } else {
                        targetInput.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                        console.log('Changed to password type');
                    }
                    
                    console.log('After toggle - type:', targetInput.type);
                } else {
                    console.error('Target input or icon not found');
                }
            });
        });
    }

    function initPasswordStrengthChecker() {
        console.log('=== INIT PASSWORD STRENGTH CHECKER ===');
        const passwordInput = document.getElementById('password');
        console.log('Password input:', passwordInput);
        
        if (!passwordInput) {
            console.error('Password input not found');
            return;
        }

        passwordInput.addEventListener('input', function() {
            console.log('Password input changed:', this.value.length + ' characters');
            const password = this.value;
            updatePasswordStrength(password);
            updatePasswordRequirements(password);
        });
        
        // Test immediately with empty string
        updatePasswordStrength('');
        updatePasswordRequirements('');
    }

    function updatePasswordStrength(password) {
        console.log('=== UPDATE PASSWORD STRENGTH ===');
        const strengthBar = document.getElementById('password-strength-bar');
        const strengthText = document.getElementById('password-strength-text');
        
        console.log('Strength bar:', strengthBar);
        console.log('Strength text:', strengthText);
        
        if (!strengthBar || !strengthText) {
            console.error('Strength elements not found');
            return;
        }

        let strength = 0;
        let message = 'None';
        let color = '#dc3545';

        console.log('Password analysis:', {
            length: password.length,
            hasLowercase: /[a-z]/.test(password),
            hasUppercase: /[A-Z]/.test(password),
            hasNumber: /\d/.test(password),
            hasSpecial: /[!@#$%^&*(),.?":{}|<>]/.test(password)
        });

        // Check various strength factors
        if (password.length >= 8) strength += 20;
        if (/[a-z]/.test(password)) strength += 20;
        if (/[A-Z]/.test(password)) strength += 20;
        if (/\d/.test(password)) strength += 20;
        if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength += 20;

        console.log('Calculated strength:', strength);

        // Determine strength level
        if (strength >= 100) {
            message = 'Strong';
            color = '#28a745';
        } else if (strength >= 80) {
            message = 'Good';
            color = '#ffc107';
        } else if (strength >= 60) {
            message = 'Fair';
            color = '#fd7e14';
        } else if (strength >= 20) {
            message = 'Weak';
            color = '#dc3545';
        }

        console.log('Final strength:', {strength, message, color});

        // Update UI
        strengthBar.style.width = strength + '%';
        strengthBar.style.backgroundColor = color;
        strengthText.textContent = 'Password strength: ' + message;
        strengthText.style.color = color;
        
        console.log('UI updated successfully');
    }

    function updatePasswordRequirements(password) {
        console.log('=== UPDATE PASSWORD REQUIREMENTS ===');
        const requirements = {
            'length': password.length >= 8,
            'uppercase': /[A-Z]/.test(password),
            'lowercase': /[a-z]/.test(password),
            'number': /\d/.test(password),
            'special': /[!@#$%^&*(),.?":{}|<>]/.test(password)
        };

        console.log('Requirements status:', requirements);

        for (const [key, met] of Object.entries(requirements)) {
            const elementId = 'req-' + key;
            const element = document.getElementById(elementId);
            console.log(`Checking ${elementId}:`, element, 'met:', met);
            
            if (element) {
                if (met) {
                    element.classList.add('valid');
                    element.classList.remove('text-danger');
                    element.innerHTML = '<i class="fas fa-check-circle me-1"></i>' + element.textContent;
                    console.log(`✓ ${elementId} requirement met`);
                } else {
                    element.classList.remove('valid');
                    element.classList.add('text-danger');
                    element.innerHTML = '<i class="fas fa-times-circle me-1"></i>' + element.textContent;
                    console.log(`✗ ${elementId} requirement not met`);
                }
            } else {
                console.error(`Element ${elementId} not found`);
            }
        }
    }

    function initPasswordMatchChecker() {
        console.log('=== INIT PASSWORD MATCH CHECKER ===');
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const matchText = document.getElementById('password-match');

        console.log('Password input:', passwordInput);
        console.log('Confirm input:', confirmInput);
        console.log('Match text:', matchText);

        if (!passwordInput || !confirmInput || !matchText) {
            console.error('Match checker elements not found');
            return;
        }

        function checkMatch() {
            const password = passwordInput.value;
            const confirm = confirmInput.value;
            console.log('Checking match - Password:', password, 'Confirm:', confirm);

            if (confirm === '') {
                matchText.textContent = '';
                matchText.className = '';
                console.log('Confirm field empty');
            } else if (password === confirm) {
                matchText.textContent = '✓ Passwords match';
                matchText.className = 'match';
                console.log('Passwords match');
            } else {
                matchText.textContent = '✗ Passwords do not match';
                matchText.className = 'no-match';
                console.log('Passwords do not match');
            }
        }

        passwordInput.addEventListener('input', checkMatch);
        confirmInput.addEventListener('input', checkMatch);
        
        // Test immediately
        checkMatch();
    }

    function initFormValidation() {
        console.log('=== INIT FORM VALIDATION ===');
        const form = document.getElementById('passwordForm');
        console.log('Form:', form);

        if (!form) {
            console.error('Form not found');
            return;
        }

        form.addEventListener('submit', function(e) {
            console.log('Form submission attempted');
            const password = document.getElementById('password')?.value;
            const confirm = document.getElementById('password_confirmation')?.value;

            console.log('Submission values - Password:', password, 'Confirm:', confirm);

            if (password !== confirm) {
                e.preventDefault();
                console.log('Preventing form submission - passwords do not match');
                alert('Error: Passwords do not match. Please make sure both password fields are identical.');
                return false;
            }

            console.log('Form submission allowed');
            return true;
        });
    }

    // Fallback: If DOMContentLoaded doesn't fire, try to initialize when window loads
    window.addEventListener('load', function() {
        console.log('=== WINDOW LOAD EVENT ===');
        debugElements();
        
        if (!document.querySelector('.toggle-password')) {
            console.log('Re-initializing features...');
            try {
                initPasswordToggle();
                initPasswordStrengthChecker();
                initPasswordMatchChecker();
                initFormValidation();
                console.log('Re-initialization complete');
            } catch (error) {
                console.error('Re-initialization error:', error);
            }
        }
    });

    // Immediate debug check
    console.log('=== IMMEDIATE DEBUG ===');
    debugElements();
    console.log('Script loading complete');
</script>
@endsection
@endsection