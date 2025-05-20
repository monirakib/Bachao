<!DOCTYPE html>
<html>
<head>
    <title>Book Flight - Bachao Airlines</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Murecho:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Murecho', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .header1 {
            background: linear-gradient(to right, #5c6bc0, #2da0a8);
            padding: 20px 50px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 100;
            box-sizing: border-box;
        }

        .back-link {
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            transform: translateX(-5px);
        }

        .container {
            max-width: 1000px;
            margin: 130px auto 40px;
            padding: 40px;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .booking-details, .payment-summary {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            padding-right: 45px;
        }

        .flight-info {
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .flight-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .route {
            display: flex;
            align-items: center;
            gap: 20px;
            font-size: 1.2em;
            color: #2c3e50;
        }

        .flight-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .detail-item {
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .detail-label {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 5px;
        }

        .detail-value {
            color: #2c3e50;
            font-weight: 600;
        }

        .passenger-form {
            margin-top: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 600;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e8ed;
            border-radius: 8px;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: #2da0a8;
            outline: none;
            box-shadow: 0 0 0 3px rgba(45, 160, 168, 0.1);
        }

        .payment-summary {
            position: sticky;
            top: 130px;
            height: fit-content;
        }

        .price-breakdown {
            margin-bottom: 30px;
        }

        .price-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 10px 0;
            border-bottom: 1px dashed #eee;
        }

        .price-item.total {
            border-top: 2px solid #eee;
            border-bottom: none;
            margin-top: 20px;
            padding-top: 20px;
            font-weight: 600;
            font-size: 1.2em;
        }

        .confirm-button {
            background: linear-gradient(to right, #5c6bc0, #2da0a8);
            color: white;
            border: none;
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .confirm-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 160, 168, 0.3);
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                margin: 110px 20px 40px;
                padding: 20px;
            }
        }

        .airplane {
            display: grid;
            gap: 10px;
            justify-content: center;
        }

        .seat-row {
            display: flex;
            gap: 10px;
        }

        .seat input[type="radio"] {
            display: none;
        }

        .seat label {
            display: block;
            width: 35px;
            height: 35px;
            border: 2px solid #2da0a8;
            border-radius: 5px;
            text-align: center;
            line-height: 35px;
            cursor: pointer;
            background: #fff;
        }

        .seat input[type="radio"]:checked + label {
            background: #2da0a8;
            color: white;
        }

        .seat.booked label {
            background: #ff4444 !important;
            border-color: #cc0000 !important;
            color: white !important;
            cursor: not-allowed;
            pointer-events: none;
        }

        .seat.booked input[type="radio"] {
            display: none;
        }

        .insurance-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .insurance-benefits {
            margin-top: 15px;
            padding: 15px;
            background: rgba(45, 160, 168, 0.1);
            border-radius: 8px;
        }

        .extras-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .checkbox-group {
            display: grid;
            gap: 15px;
            margin-top: 15px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border: 1px solid #e1e8ed;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .checkbox-label:hover {
            background: rgba(45, 160, 168, 0.05);
            border-color: #2da0a8;
        }

        .checkbox-label input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #2da0a8;
        }
    </style>
</head>
<body>
    <nav class="header1">
        <a href="<?php echo e(route('dashboard')); ?>" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </nav>

    <div class="container">
        <div class="booking-details">
            <div class="flight-info">
                <div class="flight-header">
                    <div class="route">
                        <span><?php echo e($flight->Flight_from); ?></span>
                        <i class="fas fa-plane"></i>
                        <span><?php echo e($flight->Flight_to); ?></span>
                    </div>
                    <div class="flight-id">
                        Flight #<?php echo e($flight->Flight_ID); ?>

                    </div>
                </div>

                <div class="flight-details">
                    <div class="detail-item">
                        <div class="detail-label">Departure</div>
                        <div class="detail-value"><?php echo e($flight->Start_time); ?></div>
                        <div class="detail-value"><?php echo e($flight->Start_date); ?></div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Arrival</div>
                        <div class="detail-value"><?php echo e($flight->End_time); ?></div>
                        <div class="detail-value"><?php echo e($flight->Land_date); ?></div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Duration</div>
                        <div class="detail-value"><?php echo e($flight->Duration); ?></div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Class</div>
                        <div class="detail-value"><?php echo e($flight->Type); ?></div>
                    </div>
                </div>
            </div>

            <form action="<?php echo e(route('transaction.store')); ?>" method="POST" class="passenger-form" id="bookingForm">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="user_id" value="<?php echo e(Auth::id()); ?>">
                <input type="hidden" name="flight_id" value="<?php echo e($flight->Flight_ID); ?>">
                <input type="hidden" name="amount" id="amountHidden" value="<?php echo e($flight->Price); ?>">
                <input type="hidden" name="total_amount" id="totalAmountHidden" value="0">
                <input type="hidden" name="status" value="pending">
                <input type="hidden" name="insurance_amount" id="insuranceAmountHidden" value="0">
                <input type="hidden" name="seat_type" value="<?php echo e($flight->Type); ?>">

                <h3>Passenger Information</h3>
                <div class="form-group">
                    <label for="passenger_name">Full Name (as per passport/ID)</label>
                    <input type="text" id="passenger_name" name="passenger_name" value="<?php echo e(old('passenger_name')); ?>" required>
                    <?php $__errorArgs = ['passenger_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="passport_number">Passport/NID Number</label>
                    <input type="text" id="passport_number" name="passport_number" value="<?php echo e(old('passport_number')); ?>" required>
                    <?php $__errorArgs = ['passport_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="phone">Contact Number</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo e(old('phone', Auth::user()->phone)); ?>" required>
                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo e(old('email', Auth::user()->email)); ?>" required>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label>Select Seat</label>
                    <div class="seat-map">
                        <div class="airplane">
                            <?php for($row = 1; $row <= 10; $row++): ?>
                                <div class="seat-row">
                                    <?php $__currentLoopData = ['A', 'B', 'C', 'D', 'E', 'F']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $seat_number = $row . $col;
                                            $is_booked = in_array($seat_number, $booked_seats ?? []);
                                        ?>
                                        <div class="seat <?php echo e($is_booked ? 'booked' : ''); ?>">
                                            <input type="radio" 
                                                name="seat_number" 
                                                id="<?php echo e($seat_number); ?>"
                                                value="<?php echo e($seat_number); ?>" 
                                                <?php echo e($is_booked ? 'disabled' : ''); ?>

                                                required>
                                            <label for="<?php echo e($seat_number); ?>"
                                                title="<?php echo e($is_booked ? 'Seat not available' : 'Available'); ?>">
                                                <?php echo e($seat_number); ?>

                                            </label>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>

                <div class="insurance-section">
                    <h3><i class="fas fa-shield-alt"></i> Travel Insurance</h3>
                    <div class="form-group">
                        <label>Select Insurance Plan</label>
                        <select name="insurance_plan" id="insurancePlan" onchange="calculateTotal()">
                            <option value="none">No Insurance (৳0)</option>
                            <option value="basic">Basic Coverage (৳500)</option>
                            <option value="premium">Premium Coverage (৳1,000)</option>
                            <option value="elite">Elite Coverage (৳2,000)</option>
                        </select>
                    </div>
                    <input type="hidden" name="insurance_cost" id="insuranceCostHidden" value="0">
                    <div id="insuranceDetails"></div>
                </div>

                <div class="extras-section">
                    <h3><i class="fas fa-utensils"></i> In-Flight Meal & Extras</h3>
                    
                    <div class="form-group">
                        <label>Select Meal Preference</label>
                        <select name="meal_preference" id="mealPreference" onchange="calculateTotal()">
                            <option value="none">No Meal (৳0)</option>
                            <option value="regular">Regular Meal (৳800)</option>
                            <option value="vegetarian">Vegetarian Meal (৳800)</option>
                            <option value="halal">Halal Meal (৳800)</option>
                            <option value="premium">Premium Meal with Drinks (৳1,500)</option>
                        </select>
                    </div>

                    <div class="additional-services">
                        <h4>Additional Services</h4>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="extras[]" value="baggage" data-price="1500" onchange="calculateTotal()">
                                Extra Baggage Allowance (+10kg) - ৳1,500
                            </label>
                            
                            <label class="checkbox-label">
                                <input type="checkbox" name="extras[]" value="wifi" data-price="500" onchange="calculateTotal()">
                                In-Flight Wi-Fi Access - ৳500
                            </label>
                            
                            <label class="checkbox-label">
                                <input type="checkbox" name="extras[]" value="lounge" data-price="2000" onchange="calculateTotal()">
                                Airport Lounge Access - ৳2,000
                            </label>

                            <label class="checkbox-label">
                                <input type="checkbox" name="extras[]" value="priority" data-price="800" onchange="calculateTotal()">
                                Priority Boarding - ৳800
                            </label>
                        </div>
                    </div>
                </div>

                <div class="payment-method-section">
                    <h3><i class="fas fa-money-bill"></i> Payment Method</h3>
                    <div class="form-group">
                        <label for="payment_method">Select Payment Method</label>
                        <select name="payment_method" id="payment_method" required>
                            <option value="">Select a payment method</option>
                            <option value="bkash">bKash</option>
                            <option value="nagad">Nagad</option>
                            <option value="rocket">Rocket</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="payment_number">Payment Number</label>
                        <input type="text" 
                               id="payment_number" 
                               name="payment_number" 
                               placeholder="Enter your payment number"
                               pattern="01[3-9]\d{8}"
                               title="Please enter a valid Bangladeshi mobile number"
                               required>
                    </div>
                </div>
            </form>
        </div>

        <div class="payment-summary">
            <h3>Payment Summary</h3>
            <div class="price-breakdown">
                <div class="price-item">
                    <span>Base Fare</span>
                    <span>৳<?php echo e(number_format($flight->Price, 2)); ?></span>
                </div>

                <?php if($user->reward_point >= 500): ?>
                    <div class="price-item">
                        <span>Reward Discount (5%)</span>
                        <span id="discountAmount">-৳<?php echo e(number_format($flight->Price * 0.05, 2)); ?></span>
                    </div>
                <?php endif; ?>

                <div class="price-item">
                    <span>Insurance</span>
                    <span id="insuranceCost">৳0.00</span>
                </div>

                <div class="price-item">
                    <span>Meal</span>
                    <span id="mealCost">৳0.00</span>
                </div>

                <div class="price-item">
                    <span>Extra Services</span>
                    <span id="extrasCost">৳0.00</span>
                </div>

                <div class="price-item">
                    <span>Tax (15%)</span>
                    <span id="taxAmount">৳<?php echo e(number_format($flight->Price * 0.15, 2)); ?></span>
                </div>

                <div class="price-item total">
                    <span>Total Amount</span>
                    <span id="totalAmount">৳<?php echo e(number_format($flight->Price * (1 + 0.15) - ($user->reward_point >= 500 ? $flight->Price * 0.05 : 0), 2)); ?></span>
                </div>
            </div>

            <button type="submit" form="bookingForm" class="confirm-button">
                <i class="fas fa-check-circle"></i> Confirm Booking
            </button>
        </div>
    </div>

    <script>
        function calculateTotal() {
            // Base values
            const baseFare = <?php echo e($flight->Price); ?>;
            const taxRate = 0.15;
            const rewardDiscount = <?php echo e($user->reward_point >= 500 ? 0.05 : 0); ?>;
            
            // Get insurance cost
            const insurancePlan = document.getElementById('insurancePlan').value;
            let insuranceCost = 0;
            switch(insurancePlan) {
                case 'basic': insuranceCost = 500; break;
                case 'premium': insuranceCost = 1000; break;
                case 'elite': insuranceCost = 2000; break;
            }
            
            // Get meal cost
            const mealPlan = document.getElementById('mealPreference').value;
            let mealCost = 0;
            switch(mealPlan) {
                case 'regular': case 'vegetarian': case 'halal': mealCost = 800; break;
                case 'premium': mealCost = 1500; break;
            }
            
            // Get extras cost
            let extrasCost = 0;
            document.querySelectorAll('input[name="extras[]"]:checked').forEach(checkbox => {
                extrasCost += parseInt(checkbox.dataset.price);
            });
            
            // Calculate all components
            const discountAmount = baseFare * rewardDiscount;
            const baseAfterDiscount = baseFare - discountAmount;
            const taxAmount = baseAfterDiscount * taxRate;
            const totalAmount = baseAfterDiscount + taxAmount + insuranceCost + mealCost + extrasCost;
            
            // Update all display elements
            document.getElementById('insuranceCost').textContent = '৳' + insuranceCost.toFixed(2);
            document.getElementById('mealCost').textContent = '৳' + mealCost.toFixed(2);
            document.getElementById('extrasCost').textContent = '৳' + extrasCost.toFixed(2);
            document.getElementById('taxAmount').textContent = '৳' + taxAmount.toFixed(2);
            if (rewardDiscount > 0) {
                document.getElementById('discountAmount').textContent = '-৳' + discountAmount.toFixed(2);
            }
            document.getElementById('totalAmount').textContent = '৳' + totalAmount.toFixed(2);
            
            // Update hidden fields
            document.getElementById('amountHidden').value = baseAfterDiscount;
            document.getElementById('totalAmountHidden').value = totalAmount;
            document.getElementById('insuranceAmountHidden').value = insuranceCost;

            // Update insurance details if selected
            const insuranceDetails = document.getElementById('insuranceDetails');
            if (insurancePlan !== 'none') {
                insuranceDetails.innerHTML = getInsuranceBenefits(insurancePlan);
            } else {
                insuranceDetails.innerHTML = '';
            }

            // Update meal details if selected
            const mealDetails = document.getElementById('mealDetails');
            if (mealPlan !== 'none' && mealDetails) {
                mealDetails.innerHTML = getMealDescription(mealPlan);
            } else if (mealDetails) {
                mealDetails.innerHTML = '';
            }
        }

        function getInsuranceBenefits(plan) {
            const benefits = {
                basic: [
                    'Trip cancellation coverage up to ৳10,000',
                    'Lost baggage coverage up to ৳5,000',
                    'Basic medical coverage up to ৳50,000'
                ],
                premium: [
                    'Trip cancellation coverage up to ৳25,000',
                    'Lost baggage coverage up to ৳15,000',
                    'Extended medical coverage up to ৳100,000',
                    'Flight delay compensation'
                ],
                elite: [
                    'Trip cancellation coverage up to ৳50,000',
                    'Lost baggage coverage up to ৳30,000',
                    'Comprehensive medical coverage up to ৳200,000',
                    'Flight delay compensation',
                    'Emergency evacuation coverage'
                ]
            };

            return benefits[plan] ? `
                <div class="insurance-benefits">
                    <h4>${plan.charAt(0).toUpperCase() + plan.slice(1)} Plan Benefits:</h4>
                    <ul>
                        ${benefits[plan].map(benefit => `<li>${benefit}</li>`).join('')}
                    </ul>
                </div>` : '';
        }

        function getMealDescription(mealPlan) {
            const meals = {
                regular: {
                    title: 'Regular Meal',
                    items: [
                        'Main course (chicken/fish)',
                        'Rice or bread',
                        'Seasonal vegetables',
                        'Dessert',
                        'Soft drink'
                    ]
                },
                vegetarian: {
                    title: 'Vegetarian Meal',
                    items: [
                        'Vegetable curry',
                        'Rice or bread',
                        'Fresh salad',
                        'Fruit dessert',
                        'Soft drink'
                    ]
                },
                halal: {
                    title: 'Halal Meal',
                    items: [
                        'Halal certified main course',
                        'Rice or bread',
                        'Seasonal vegetables',
                        'Halal dessert',
                        'Soft drink'
                    ]
                },
                premium: {
                    title: 'Premium Meal with Drinks',
                    items: [
                        'Gourmet main course',
                        'Premium sides',
                        'Fresh salad',
                        'Signature dessert',
                        'Choice of beverages including alcohol',
                        'Premium snacks'
                    ]
                }
            };

            const meal = meals[mealPlan];
            return `
                <div class="meal-details">
                    <h4>${meal.title}</h4>
                    <ul>
                        ${meal.items.map(item => `<li>${item}</li>`).join('')}
                    </ul>
                </div>
            `;
        }

        // Calculate initial total on page load and add event listeners
        document.addEventListener('DOMContentLoaded', function() {
            calculateTotal();
            
            // Add event listeners for all form elements that affect price
            document.getElementById('insurancePlan').addEventListener('change', calculateTotal);
            document.getElementById('mealPreference').addEventListener('change', calculateTotal);
            document.querySelectorAll('input[name="extras[]"]').forEach(checkbox => {
                checkbox.addEventListener('change', calculateTotal);
            });

            // Prevent clicking on booked seats
            document.querySelectorAll('.seat.booked').forEach(seat => {
                seat.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                });
            });

            // Add tooltip for booked seats
            document.querySelectorAll('.seat.booked label').forEach(label => {
                label.title = 'This seat is already booked';
            });
        });

        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate required fields
            const requiredFields = {
                'passenger_name': 'Passenger Name',
                'passport_number': 'Passport/NID Number',
                'phone': 'Contact Number',
                'email': 'Email',
                'seat_number': 'Seat',
                'payment_method': 'Payment Method',
                'payment_number': 'Payment Number'
            };

            let isValid = true;
            let errorMessage = '';

            for (let [field, label] of Object.entries(requiredFields)) {
                const element = document.querySelector(`[name="${field}"]`);
                if (!element.value.trim()) {
                    isValid = false;
                    errorMessage += `${label} is required\n`;
                }
            }

            // Validate seat selection
            if (!document.querySelector('input[name="seat_number"]:checked')) {
                isValid = false;
                errorMessage += 'Please select a seat\n';
            }

            if (!isValid) {
                alert('Please fill in all required fields:\n\n' + errorMessage);
                return;
            }

            // If all validations pass, submit the form
            this.submit();
        });
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\Bachao\airline\resources\views/transactions/create.blade.php ENDPATH**/ ?>