@extends('layouts.index_welcome')
@section('content')

        <div class="row g-4">
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <div class="ms-3">
                        <p class="mb-2">عدد الطلاب</p>
                        <h6 class="mb-0" >{{ \App\Models\Student::count() }}</h6>
                    </div>
                    <img src="{{ asset('img/dash-icon-01.svg') }}" alt="">
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <div class="ms-3">
                        <p class="mb-2">عدد المعلمين </p>
                        <h6 class="mb-0">{{ \App\Models\Teacher::count() }}</h6>
                    </div>
                    <img src="{{ asset('img/dash-icon-02.svg') }}" alt="">
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <div class="ms-3">
                        <p class="mb-2">عدد الصفوف</p>
                        <h6 class="mb-0">{{ \App\Models\SchoolClass::count() }}</h6>
                    </div>
                    <img src="{{ asset('img/dash-icon-03.svg') }}" alt="">
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <div class="ms-3">
                        <p class="mb-2">عدد المدارس</p>
                        <h6 class="mb-0">{{ \App\Models\School::count() }}</h6>
                    </div>
                    <img src="{{ asset('img/dash-icon-04.svg') }}" alt="">
                </div>
            </div>
            
        </div> 

<section id="dashboard-analytics">
                    <div class="row match-height">
                        <!-- Greetings Card starts -->
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="card card-congratulations">
                                <div class="card-body text-center">
                                    <img src="../../../app-assets/images/elements/decore-left.png" class="congratulations-img-left" alt="card-img-left" />
                                    <img src="../../../app-assets/images/elements/decore-right.png" class="congratulations-img-right" alt="card-img-right" />
                                    <div class="avatar avatar-xl bg-primary shadow">
                                        <div class="avatar-content">
                                            <i data-feather="award" class="font-large-1"></i>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <h1 class="mb-1 text-white">       @if(Auth::check())
                               Welcome {{ Auth::user()->name }}
                            @else
                                Welcome Guest
                            @endif</h1>
                                        <p class="card-text m-auto w-75">
                                            You have done <strong>57.6%</strong> more sales today. Check your new badge in your profile.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Greetings Card ends -->

                        <!-- Subscribers Chart Card starts -->
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-primary p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="users" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="fw-bolder mt-1">92.6k</h2>
                                    <p class="card-text">Subscribers Gained</p>
                                </div>
                                <div id="gained-chart"></div>
                            </div>
                        </div>
                        <!-- Subscribers Chart Card ends -->

                        <!-- Orders Chart Card starts -->
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header flex-column align-items-start pb-0">
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="package" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                    <h2 class="fw-bolder mt-1">38.4K</h2>
                                    <p class="card-text">Orders Received</p>
                                </div>
                                <div id="order-chart"></div>
                            </div>
                        </div>
                        <!-- Orders Chart Card ends -->
                    </div>

                    <div class="row match-height">
                        <!-- Avg Sessions Chart Card starts -->
                        <div class="col-lg-6 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row pb-50">
                                        <div class="col-sm-6 col-12 d-flex justify-content-between flex-column order-sm-1 order-2 mt-1 mt-sm-0">
                                            <div class="mb-1 mb-sm-0">
                                                <h2 class="fw-bolder mb-25">2.7K</h2>
                                                <p class="card-text fw-bold mb-2">Avg Sessions</p>
                                                <div class="font-medium-2">
                                                    <span class="text-success me-25">+5.2%</span>
                                                    <span>vs last 7 days</span>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-primary">View Details</button>
                                        </div>
                                        <div class="col-sm-6 col-12 d-flex justify-content-between flex-column text-end order-sm-2 order-1">
                                            <div class="dropdown chart-dropdown">
                                                <button class="btn btn-sm border-0 dropdown-toggle p-50" type="button" id="dropdownItem5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Last 7 Days
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownItem5">
                                                    <a class="dropdown-item" href="#">Last 28 Days</a>
                                                    <a class="dropdown-item" href="#">Last Month</a>
                                                    <a class="dropdown-item" href="#">Last Year</a>
                                                </div>
                                            </div>
                                            <div id="avg-sessions-chart"></div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row avg-sessions pt-50">
                                        <div class="col-6 mb-2">
                                            <p class="mb-50">Goal: $100000</p>
                                            <div class="progress progress-bar-primary" style="height: 6px">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="50" aria-valuemax="100" style="width: 50%"></div>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <p class="mb-50">Users: 100K</p>
                                            <div class="progress progress-bar-warning" style="height: 6px">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="60" aria-valuemax="100" style="width: 60%"></div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p class="mb-50">Retention: 90%</p>
                                            <div class="progress progress-bar-danger" style="height: 6px">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="70" aria-valuemax="100" style="width: 70%"></div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p class="mb-50">Duration: 1yr</p>
                                            <div class="progress progress-bar-success" style="height: 6px">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="90" aria-valuemax="100" style="width: 90%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Avg Sessions Chart Card ends -->

                        <!-- Support Tracker Chart Card starts -->
                        <div class="col-lg-6 col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between pb-0">
                                    <h4 class="card-title">Support Tracker</h4>
                                    <div class="dropdown chart-dropdown">
                                        <button class="btn btn-sm border-0 dropdown-toggle p-50" type="button" id="dropdownItem4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Last 7 Days
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownItem4">
                                            <a class="dropdown-item" href="#">Last 28 Days</a>
                                            <a class="dropdown-item" href="#">Last Month</a>
                                            <a class="dropdown-item" href="#">Last Year</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-2 col-12 d-flex flex-column flex-wrap text-center">
                                            <h1 class="font-large-2 fw-bolder mt-2 mb-0">163</h1>
                                            <p class="card-text">Tickets</p>
                                        </div>
                                        <div class="col-sm-10 col-12 d-flex justify-content-center">
                                            <div id="support-trackers-chart"></div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-1">
                                        <div class="text-center">
                                            <p class="card-text mb-50">New Tickets</p>
                                            <span class="font-large-1 fw-bold">29</span>
                                        </div>
                                        <div class="text-center">
                                            <p class="card-text mb-50">Open Tickets</p>
                                            <span class="font-large-1 fw-bold">63</span>
                                        </div>
                                        <div class="text-center">
                                            <p class="card-text mb-50">Response Time</p>
                                            <span class="font-large-1 fw-bold">1d</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Support Tracker Chart Card ends -->
                    </div>


            <!-- Dashboard End -->

            <!-- total students -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="bg-light text-center rounded p-2" style="height: 480px;">
                            <h6 class="mb-0">Number of students</h6>
                            <a href="#" style="font-size: 12px;">Show All</a>
                            <canvas id="students" style="max-height: 400px;"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light text-center rounded p-2" style="height: 480px;">
                            <h6 class="mb-0">Overview</h6>
                            <a href="#" style="font-size: 12px;">Show All</a>
                            <canvas id="overview" style="max-height: 400px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- total students End -->
   <!-- END: Main Menu-->

    <!-- BEGIN: Content-->


            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="text-c  rounded-top p-4">
                    <div class="row">
                        <div class=" col-12 col-sm-6 text-center text-sm-start">
                            Copyright &copy;  bright code
                        </div>
                      
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/chart/chart.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        $(document).ready(function(){
            // Redirect user to login page when clicking on login link
            $('a[href="{{ route('login') }}"]').on('click', function(e){
                e.preventDefault();
                window.location.href = $(this).attr('href');
            });
        });
    </script>
<script>
    var ctx1 = $("#students").get(0).getContext("2d");

    // استعلام لجلب عدد الذكور
    var numberOfMales = {{ \App\Models\Student::where('gender', 'ذكر')->count() }};

    // استعلام لجلب عدد الإناث
    var numberOfFemales = {{ \App\Models\Student::where('gender', 'أنثى')->count() }};

    var myChart1 = new Chart(ctx1, {
        type: "doughnut", // تغيير نوع الرسم البياني إلى "Doughnut"
        data: {
            labels: ["ذكور", "إناث"], // تسميات الأقسام
            datasets: [{
                label: "العدد الكلي",
                data: [numberOfMales, numberOfFemales], // بيانات الذكور والإناث
                backgroundColor: ["rgba(0, 156, 255, .3)", "rgba(255, 99, 132, 0.5)"] // ألوان الخلفيات
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true, // تحافظ على نسبة العرض إلى الارتفاع
            plugins: {
                legend: {
                    labels: {
                        fontSize: 12 // تقليل حجم النصوص في الأسطح الجانبية
                    }
                }
            }
        }
    });
</script>


<script>
    // استخدام الرسم البياني الدائري بدلاً من الرسم البياني الشريطي
    var ctx2 = document.getElementById('overview').getContext('2d');
    
    // جلب عدد الطلاب والمعلمين وعدد المدارس من النماذج
    var numberOfStudents = {{ \App\Models\Student::count() }};
    var numberOfTeachers = {{ \App\Models\Teacher::count() }};
    var numberOfSchools = {{ \App\Models\School::count() }};
    
    var myChart2 = new Chart(ctx2, {
        type: "pie", // تغيير نوع الرسم البياني إلى الرسم البياني الدائري
        data: {
            labels: ["Teachers", "Students", "Schools"],
            datasets: [{
                label: "Number of Teachers, Students, and Schools",
                data: [numberOfTeachers, numberOfStudents, numberOfSchools],
                backgroundColor: ["green", "rgba(0, 156, 255, .3)", "orange"], // ألوان القطاعات المخصصة
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true, // تحافظ على نسبة العرض إلى الارتفاع
            plugins: {
                legend: {
                    labels: {
                        fontSize: 12 // تقليل حجم النصوص في الأسطح الجانبية
                    }
                }
            }
        }
    });
</script>
@endsection
