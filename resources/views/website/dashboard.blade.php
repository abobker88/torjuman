
@extends('layouts.website')

@section('content')
<div class="container tabs-container">
    <div class="user-greeting-mobile user-greeting">Hello, Abdullah</div>

    <div class="tabs">
      <div class="d-flex align-items-start">
        <div
          class="nav flex-column nav-pills me-3"
          id="v-pills-tab"
          role="tablist"
          aria-orientation="vertical"
        >
          <div class="user-greeting-desktop user-greeting">
            Hello, Abdullah
          </div>
          <button
            class="nav-link active"
            id="v-pills-home-tab"
            data-bs-toggle="pill"
            data-bs-target="#v-pills-home"
            type="button"
            role="tab"
            aria-controls="v-pills-home"
            aria-selected="true"
          >
            <span class="tab-span">Services</span>
          </button>
          <button
            class="nav-link"
            id="v-pills-profile-tab"
            data-bs-toggle="pill"
            data-bs-target="#v-pills-profile"
            type="button"
            role="tab"
            aria-controls="v-pills-profile"
            aria-selected="false"
          >
            <span class="tab-span">Orders</span>
          </button>
          <button
            class="nav-link"
            id="v-pills-messages-tab"
            data-bs-toggle="pill"
            data-bs-target="#v-pills-messages"
            type="button"
            role="tab"
            aria-controls="v-pills-messages"
            aria-selected="false"
          >
            <span class="tab-span">Acount</span>
          </button>
        </div>
        <div class="tab-content" id="v-pills-tabContent">
          <div
            class="tab-pane fade show active"
            id="v-pills-home"
            role="tabpanel"
            aria-labelledby="v-pills-home-tab"
          >
            <!-- Services summary -->
            <div class="service-summary">
              <div class="projects-done service-summary-pane">
                <div class="projects-done-count count">0</div>
                <div class="projects-done-title title">
                  Projects we worked on
                </div>
              </div>
              <div class="translators-worked service-summary-pane">
                <div class="translators-worked-count count">0</div>
                <div class="translators-worked-title title">
                  Translators worked for you
                </div>
              </div>
              <div class="balance service-summary-pane">
                <div class="balance-count count">0</div>
                <div class="balance-title title">Balance</div>
              </div>
            </div>
            <!-- / Service summary -->
            <!-- Services list -->
            <section class="services dashboard-services" id="services">
              <div class="service-boxes">
                <div class="service-box">
                  <img
                    loading="lazy"
                    src="{{asset('storage/img/assets/services1.svg')}}"
                    alt=""
                    class="service-svg"
                  />
                  <h4 class="service-title">one sheet</h4>
                </div>
                <div class="service-box">
                  <img
                    loading="lazy"
                    src="{{asset('storage/img/assets/services2.svg')}}"
                    alt=""
                    class="service-svg"
                  />
                  <h4 class="service-title">10 sheets or less</h4>
                </div>
                <div class="service-box">
                  <img
                    loading="lazy"
                    src="{{asset('storage/img/assets/services3.svg')}}"
                    alt=""
                    class="service-svg"
                  />
                  <h4 class="service-title">Simultaneous translation</h4>
                </div>
                <div class="service-box">
                  <img
                    loading="lazy"
                    src="{{asset('storage/img/assets/services4.svg')}}"
                    alt=""
                    class="service-svg"
                  />
                  <h4 class="service-title">research and books</h4>
                </div>

                <div class="service-box">
                  <img
                    loading="lazy"
                    src="{{asset('storage/img/assets/services5.svg')}}"
                    alt=""
                    class="service-svg"
                  />
                  <h4 class="service-title">Request an interpreter</h4>
                </div>
                <div class="service-box">
                  <img
                    loading="lazy"
                    src="{{asset('storage/img/assets/services6.svg')}}"
                    alt=""
                    class="service-svg"
                  />
                  <h4 class="service-title">Companies and Institutions</h4>
                </div>
                <div class="service-box">
                  <img
                    loading="lazy"
                    src="{{asset('storage/img/assets/services7.svg')}}"
                    alt=""
                    class="service-svg"
                  />
                  <h4 class="service-title">Drafting letters</h4>
                </div>
                <div class="service-box">
                  <img
                    loading="lazy"
                    src="  {{asset('storage/img/assets/services8.svg')}}"
                    alt=""
                    class="service-svg"
                  />
                  <h4 class="service-title">Free trial</h4>
                </div>
              </div>
            </section>
            <!-- / Services list -->
          </div>

          <!-- Orders -->
          
          <div
            class="tab-pane fade"
            id="v-pills-profile"
            role="tabpanel"
            aria-labelledby="v-pills-profile-tab"
          >
          <div class="back-to-order">&lt; Back to Orders</div> 
            <ul
              class="nav nav-pills mb-3 orders-tabs"
              id="pills-tab"
              role="tablist"
            >
              <li class="nav-item orders-tabs-nav" role="presentation">
                <button
                  class="nav-link active"
                  id="pills-home-tab"
                  data-bs-toggle="pill"
                  data-bs-target="#pills-home"
                  type="button"
                  role="tab"
                  aria-controls="pills-home"
                  aria-selected="true"
                >
                  <span>Custom Orders<span>
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button
                  class="nav-link"
                  id="pills-profile-tab"
                  data-bs-toggle="pill"
                  data-bs-target="#pills-profile"
                  type="button"
                  role="tab"
                  aria-controls="pills-profile"
                  aria-selected="false"
                >
                  <span>Previous Orders<span>
                </button>
              </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
              <div
                class="tab-pane fade show active"
                id="pills-home"
                role="tabpanel"
                aria-labelledby="pills-home-tab"
              >
                <div class="order-tracking">
    <div class="order-tracking-top">
      <div class="tracking-pane">
        <div class="order-number">
          <span> Order 65433345 </span>
        </div>
        <div class="order-date">Placed on Oct 21, 2021</div>
      </div>
      <div class="order-next">&gt;</div>
    </div>
    <div class="number-of-sheets">
      <span> One Sheet </span>
    </div>
    <div class="progress-tracker">
      <div class="order-created order-status">
        <div class="svg-holder">
          <span>
            <img
              src=" {{asset('storage/img/assets/order-tick.svg')}}"
              alt="tick"
              class="tick-circle"
            />
          </span>
          <span>
            <img
              src="{{asset('storage/img/assets/progress-line.svg')}}"
              alt=""
              class="progress-line"
            />
          </span>
        </div>
        <div class="order-created-text active status-text">
          Order has been created
        </div>
      </div>
      <div class="review-state order-status">
        <div class="svg-holder">
          <span>
            <img
              src="{{asset('storage/img/assets/progress-circle.svg')}}"
              alt="progress-circle"
              class="tick-circle"
            />
          </span>
          <span>
            <img
              src=" {{asset('storage/img/assets/progress-line.svg')}}"
              alt=""
              class="progress-line"
            />
          </span>
        </div>
        <div class="order-created-text status-text">
          Order on review state
        </div>
      </div>
      <div class="payment-waiting order-status">
        <div class="svg-holder">
          <span>
            <img
              src="{{asset('storage/img/assets/progress-circle.svg')}}"
              alt="progress-circle"
              class="tick-circle"
            />
          </span>
          <span>
            <img
              src=" {{asset('storage/img/assets/progress-line.svg')}}"
              alt=""
              class="progress-line"
            />
          </span>
        </div>
        <div class="order-created-text status-text">Payment waiting</div>
      </div>
      <div class="working order-status">
        <div class="svg-holder">
          <span>
            <img
              src="{{asset('storage/img/assets/progress-circle.svg')}}"
              alt="progress-circle"
              class="tick-circle"
            />
          </span>
          <span>
            <img
              src=" {{asset('storage/img/assets/progress-line.svg')}}"
              alt=""
              class="progress-line"
            />
          </span>
        </div>
        <div class="order-created-text status-text">working on it</div>
      </div>
      <div class="order-done order-status">
        <div class="svg-holder">
          <span>
            <img
              src=" {{asset('storage/img/assets/progress-circle.svg')}}"
              alt="progress-circle"
              class="tick-circle"
            />
          </span>
        </div>
        <div class="order-created-text status-text">Done!</div>
      </div>
    </div>
    <div class="order-tracking-bottom">
      <div class="order-total">
        <span> Total </span>
        <span class="currency-symbol">R</span>
        <span class="total-amount"> 15.00 </span>
      </div>
      <div class="customer-service">
        <button class="support-btn">
          <span><img src="{{asset('storage/img/assets/support-icon.svg')}}" alt="" /></span>
          Custom Service
        </button>
      </div>
    </div>
  </div>
              </div>
              <div
                class="tab-pane fade"
                id="pills-profile"
                role="tabpanel"
                aria-labelledby="pills-profile-tab"
              >
                Previous Orders
              </div>
            </div>
          </div>
          <!-- / Orders -->

          <!-- Account -->
          <div
            class="tab-pane fade"
            id="v-pills-messages"
            role="tabpanel"
            aria-labelledby="v-pills-messages-tab"
          >
            Lorem, ipsum dolor.
          </div>
          <!-- / Account -->
        </div>
      </div>
    </div>

    
  </div>
  
<!-- Help button -->

<div class="help-button">
      <button class="help-btn">
        <span><img src="  {{asset('storage/img/assets/help.svg')}}" alt="" /></span>
        Help
      </button>
    </div>

    @endsection