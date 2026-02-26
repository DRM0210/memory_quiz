<style>
    #accordionExample {
        border: 1px solid #e5e5e5;
        padding: 5px;
    }

    .card {
        --bs-card-border-color: #e5e5e5;
        --bs-card-inner-border-radius: unhset;
        --bs-card-border-radius: 0rem;
    }

    .accordion {
        --bs-accordion-border-color: unset;
        --bs-accordion-border-radius: unset;
    }

    .card.accordion-item {
        /*! box-shadow: 0 0.125rem 0.25rem rgba(161, 172, 184, 0.4); */
        border: 1px solid #e5e5e5;
    }

    .accordion>.card:not(:last-of-type) {
        border-radius: 0rem !important;
        margin-bottom: 1px;
    }

    .h2 {
        line-height: 0;
    }

    .accordion-header {
        line-height: 0;
    }

    .accordion-button {
        background: #e5e5e5 !important;
        ;
        border-radius: 0 !important;
    }

    .card.accordion-item {
        box-shadow: unset;
    }

    .right-link li {
        border: 1px solid #e5e5e5;
        padding: 17px;
    }

    .right-link li a {
        color: #566a7f;
    }

    .right-link li active {
        background: red;
    }

    .accordion-body {
        padding: 0;
    }

    .menu-item.active {
        background: #0063a6;
    }

    .menu-item.active a {
        color: #fff;
    }
</style>
<div class="accordion" id="accordionExample">

  <!-- Company Setting (admin-setting) -->
  <div class="card accordion-item">
      <h2 class="accordion-header" id="headingOne">
          <button type="button" class="accordion-button {{ Route::is(['admin-setting', 'admin.setting.update']) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#accordionOne" aria-expanded="{{ Route::is(['admin-setting', 'admin.setting.update']) ? 'true' : 'false' }}" aria-controls="accordionOne">
              Admin Setting
          </button>
      </h2>
      <div id="accordionOne" class="accordion-collapse collapse {{ Route::is(['admin-setting', 'admin.setting.update']) ? 'show' : '' }}" aria-labelledby="headingOne">
          <div class="accordion-body">
              <ul class="menu-sub d-block right-link">
                  <li class="menu-item {{ Route::is(['admin-setting', 'admin.setting.update']) ? 'active' : '' }} pt-2 pb-2">
                      <a href="{{ route('admin-setting') }}" class="menu-link">
                          <div>Company Information</div>
                      </a>
                  </li>
              </ul>
          </div>
      </div>
  </div>

  <!-- Quiz Type Master -->
  <div class="card accordion-item">
      <h2 class="accordion-header" id="headingQuizType">
          <button type="button" class="accordion-button {{ Route::is(['quiz-type.*']) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#accordionQuizType" aria-expanded="{{ Route::is(['quiz-type.*']) ? 'true' : 'false' }}" aria-controls="accordionQuizType">
              Quiz Type Master
          </button>
      </h2>
      <div id="accordionQuizType" class="accordion-collapse collapse {{ Route::is(['quiz-type.*']) ? 'show' : '' }}" aria-labelledby="headingQuizType">
          <div class="accordion-body">
              <ul class="menu-sub d-block right-link">
                  <li class="menu-item {{ Route::is(['quiz-type.index', 'quiz-type.create', 'quiz-type.edit']) ? 'active' : '' }} pt-2 pb-2">
                      <a href="{{ route('quiz-type.index') }}" class="menu-link">
                          <div>Quiz Types</div>
                      </a>
                  </li>
              </ul>
          </div>
      </div>
  </div>

</div>
