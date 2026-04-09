@extends('layouts.user_type.auth')

@section('content')

<style>
  .dashboard-bg-wrap {
    position: relative;
    min-height: 78vh;
    border-radius: 1.5rem;
    overflow: hidden;
    padding: 1.25rem;
    background-image:
      linear-gradient(rgba(255,255,255,0.70), rgba(255,255,255,0.82)),
      url("{{ asset('assets/img/hospital-bg.jpg') }}");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }

  .blood-card {
    border: 1px solid rgba(128, 0, 0, 0.08);
    box-shadow: 0 10px 24px rgba(128, 0, 0, 0.08);
    transition: 0.25s ease;
    border-radius: 1rem;
    background: rgba(255, 255, 255, 0.88);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
  }

  .blood-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 28px rgba(128, 0, 0, 0.12);
  }

  .bg-gradient-blood {
    background: linear-gradient(135deg, #c40000 0%, #7a0000 100%);
    color: #fff;
    box-shadow: 0 8px 18px rgba(179, 0, 0, 0.22);
  }

  .blood-title {
    color: #7a1c1c;
    font-weight: 700;
  }

  .blood-value {
    color: #3f0b0b;
  }
</style>

<div class="dashboard-bg-wrap">
  <div class="row">

    <!-- Latest Active Donation -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card blood-card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold blood-title">
                  Latest Active Donation
                </p>
                <h5 class="font-weight-bolder mb-0 blood-value" style="font-size: 15px">
                  {{ $latest_active?->schedules[0]?->date ?? 'No active donation yet' }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-blood shadow text-center border-radius-md">
                <i class="ni ni-favourite-28 text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Latest Request -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card blood-card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold blood-title">
                  Latest Request
                </p>
                <h5 class="font-weight-bolder mb-0 blood-value" style="font-size: 14px">
                  {{ $latest?->created_at ? 'Created At ' . $latest?->created_at?->format('m-d-Y') : 'No request yet' }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-blood shadow text-center border-radius-md">
                <i class="ni ni-notification-70 text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Total Requests -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card blood-card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold blood-title">
                  Total Requests
                </p>
                <h5 class="font-weight-bolder mb-0 blood-value">
                  {{ $all_count }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-blood shadow text-center border-radius-md">
                <i class="ni ni-collection text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Scheduled Request -->
    <div class="col-xl-3 col-sm-6 mb-4">
      <div class="card blood-card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold blood-title">
                  Scheduled Request
                </p>
                <h5 class="font-weight-bolder mb-0 blood-value">
                  {{ $all_scheduled_count }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-blood shadow text-center border-radius-md">
                <i class="ni ni-calendar-grid-58 text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection

@push('dashboard')
<script>
  window.onload = function() {
    var chartBars = document.getElementById("chart-bars");
    if (chartBars) {
      var ctx = chartBars.getContext("2d");

      new Chart(ctx, {
        type: "bar",
        data: {
          labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [{
            label: "Sales",
            tension: 0.4,
            borderWidth: 0,
            borderRadius: 4,
            borderSkipped: false,
            backgroundColor: "#fff",
            data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
            maxBarThickness: 6
          }],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
              },
              ticks: {
                suggestedMin: 0,
                suggestedMax: 500,
                beginAtZero: true,
                padding: 15,
                font: {
                  size: 14,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
                color: "#fff"
              },
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false
              },
              ticks: {
                display: false
              },
            },
          },
        },
      });
    }

    var chartLine = document.getElementById("chart-line");
    if (chartLine) {
      var ctx2 = chartLine.getContext("2d");

      var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);
      gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
      gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)');

      var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);
      gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
      gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
      gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)');

      new Chart(ctx2, {
        type: "line",
        data: {
          labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
          datasets: [
            {
              label: "Mobile apps",
              tension: 0.4,
              pointRadius: 0,
              borderColor: "#cb0c9f",
              borderWidth: 3,
              backgroundColor: gradientStroke1,
              fill: true,
              data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
              maxBarThickness: 6
            },
            {
              label: "Websites",
              tension: 0.4,
              pointRadius: 0,
              borderColor: "#3A416F",
              borderWidth: 3,
              backgroundColor: gradientStroke2,
              fill: true,
              data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
              maxBarThickness: 6
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false,
            }
          },
          interaction: {
            intersect: false,
            mode: 'index',
          },
          scales: {
            y: {
              grid: {
                drawBorder: false,
                display: true,
                drawOnChartArea: true,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                padding: 10,
                color: '#b2b9bf',
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
            x: {
              grid: {
                drawBorder: false,
                display: false,
                drawOnChartArea: false,
                drawTicks: false,
                borderDash: [5, 5]
              },
              ticks: {
                display: true,
                color: '#b2b9bf',
                padding: 20,
                font: {
                  size: 11,
                  family: "Open Sans",
                  style: 'normal',
                  lineHeight: 2
                },
              }
            },
          },
        },
      });
    }
  }
</script>
@endpush