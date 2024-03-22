<section class="cg_tariffs">
    <div class="cg_tariffs__balance">
        <h2 data-lang="cg_tariffs_balance_title">Your package balances:</h2>

        <div>
            <p>
                <span data-lang="cg_tariffs_balance_phone">Phone numbers - </span>
                <span>{{$phoneCount}} pcs</span>
            </p>
        </div>

        <div>
            <p>
                <span data-lang="cg_tariffs_balance_email">Email - </span>
                <span>{{$emailCount}} pcs</span>
            </p>
        </div>
    </div>

    <h1 class="h1 cg_tariffs__title" data-lang="cg_tariffs_title">Packages</h1>

    <div class="cg_tariffs__content">
        @foreach($data as $key=>$tarif)
            @if($key == 0)
                <div class='cg_tariff cg_tariff_free'>
                    <h3 class='cg_tariff__title'>{{$tarif['title']}}</h3>

                    <div class='cg_tariff__info'>
                        @foreach($tarif['features'] as $feature)
                            <div class='cg_tariff__item'>
                                <div class='cg_tariff__icon'>
                                    @if($feature['enabled'])
                                        <span>&#10003</span>
                                    @else
                                        <span>&#10060</span>
                                    @endif
                                </div>

                                <div class='cg_tariff__item-group'>
                                    <p class='cg_tariff__item-title'>{{$feature['description']}}</p>
                                    <small class='cg_tariff__desc'>{{$feature['conditions']}}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class='cg_tariff__count'>If You do not have paid contacts on Your account, these rules are
                        applied by default.
                    </div>
                </div>
                    @continue
            @endif
            @if($key == 4)
                <div class="cg_special_tariff">
                    <div class="cg_special_tariff__title">YEAR UNLIMIT</div>

                    <div class="cg_special_tariff__info">
                        <div class="cg_special_tariff__item">
                            <div class="cg_special_tariff__icon">
                                <span>&#10003</span>
                            </div>
                            <div class="cg_special_tariff__item-group">
                                <p class="cg_special_tariff__item-title">No restrictions on collecting contacts</p>
                            </div>
                        </div>

                        <div class="cg_special_tariff__item">
                            <div class="cg_special_tariff__icon">
                                <span>&#10003</span>
                            </div>

                            <div class="cg_special_tariff__item-group">
                                <p class="cg_special_tariff__item-title">2 active games allowed at the same time</p>
                            </div>
                        </div>

                        <div class="cg_special_tariff__item">
                            <div class="cg_special_tariff__icon">
                                <span>&#10003</span>
                            </div>

                            <div class="cg_special_tariff__item-group">
                                <p class="cg_special_tariff__item-title">200 emails per day available</p>
                            </div>
                        </div>
                    </div>

                    <div class="cg_special_tariff__count">{{$tarif['price']}} for 365 days</div>

                    <div class="cg_special_tariff__connect">
                        @if($activeGames['meta']['total'] > 1)
                            <button
                                    type='button'
                                    class="btn purple"
                                    data-lang="cg_tariffs_connect"
                                    onclick="onWarningTariff('https://cloudsgoods.com/tariff?token={{$token}}', <?php echo $activeGames['meta']['total']?>)"
                            >
                                Choose a package
                            </button>
                        @else
                            <a
                                    href="https://cloudsgoods.com/tariff?token={{$token}}"
                                    target="_blank"
                                    type='button'
                                    class="btn"
                                    data-lang="cg_tariffs_connect"
                            >
                                Choose a package
                            </a>
                        @endif
                    </div>
                </div>
                    @continue
            @endif
            <div class='cg_tariff'>
                <h3 class='cg_tariff__title'>{{$tarif['title']}}</h3>

                <div class='cg_tariff__info'>
                    @foreach($tarif['features'] as $feature)
                        <div class='cg_tariff__item'>
                            <div class='cg_tariff__icon'>
                                @if($feature['enabled'])
                                    <span>&#10003</span>
                                @else
                                    <span>&#10060</span>
                                @endif
                            </div>

                            <div class='cg_tariff__item-group'>
                                <p class='cg_tariff__item-title'>{{$feature['description']}}</p>
                                <small class='cg_tariff__desc'>{{$feature['conditions']}}</small>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class='cg_tariff__count'>PRICE: {{$tarif['price']}}</div>

                <div class='cg_tariff__connect'>
                    <a
                            href="https://cloudsgoods.com/tariff?token={{$token}}"
                            target="_blank"
                            type='button'
                            class="btn"
                            data-lang="cg_tariffs_connect"
                    >
                        Choose a package
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="cg_tariffs__modal"></div>
</section>

<script>
  const modalTemplate = (data) => {
    return `
        <div class="cg_modal-mask cg_warning-tariff-modal">
          <div class="cg_modal-wrapper" onclick="closeModal()"></div>
          <div class="cg_modal-container">
              <div class="cg_modal-header">
                  <button type="button" class="cg_close" onclick="closeModal()">×</button>
              </div>
              <div class="cg_modal-body">
                  <p>Please note that only 2 games can be active at the same time on this plan.</p>
                  <p>Your current games are: <span class="error">${ data.count }</span></p>
                  <p>Launched games will be suspended upon activation of the tariff, and you will need to manually activate the previously created 2 games.</p>
                  <p>Don't worry, you won't lose any data.</p>
                  <button class="btn purple" type="button" onclick="onContinue('${ data.link }')">Continue</button>
              </div>
          </div>
        </div>
      `;
  };

  const onWarningTariff = (link, count) => {
    _render([{ link, count }], 'cg_tariffs__modal', modalTemplate);
  };

  const onContinue = (link) => {
    const a = document.createElement('a');

    a.href = link;
    a.setAttribute('target', '_blank');
    document.body.appendChild(a);
    a.click();
    a.remove();

    closeModal();
  };

  const
      _render = (data, selector, template, render = true) => {
        const block = document.querySelector(`.${ selector }`);
        block.innerHTML = '';

        if(render) {
          if(data) {
            data.forEach((prize, index) => block.innerHTML += template(prize, index));
          } else {
            block.innerHTML = template();
          }
        }
      },
      closeModal = () => {
        const modal = document.querySelector('.cg_modal-mask');
        modal.remove();
      };
</script>

<style>
  @include('../assets/app.css')
  .cg_tariffs {
    padding-right: 20px;
  }

  @media (max-width: 782px) {
    .cg_tariffs {
      padding-right: 10px;
    }
  }

  .cg_tariffs__balance {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .cg_tariffs__balance div {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .cg_tariffs__balance div p {
    color: #000;
    font-size: 16px;
    line-height: 19px;
    margin: 0;
  }

  .cg_tariffs__balance div button {
    border: 1px solid #8a60ff;
    outline: none;
    color: #000;
    padding: 5px 10px;
    cursor: pointer;
    background-color: transparent;
    transition: all .25s linear;
    border-radius: 30px;
  }

  .cg_tariffs__balance div button:hover {
    background-color: #8a60ff;
    color: #fff;
  }

  .cg_tariffs__content {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-gap: 20px;
    max-width: 1400px;
  }

  @media (max-width: 1500px) {
    .cg_tariffs__content {
      grid-template-columns: repeat(3, 1fr);
    }
  }

  @media (max-width: 1200px) {
    .cg_tariffs__content {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 782px) {
    .cg_tariffs__content {
      grid-gap: 10px;
    }
  }

  @media (max-width: 650px) {
    .cg_tariffs__content {
      grid-template-columns: 1fr;
    }
  }

  .cg_tariff {
    border: 1px solid #8a60ff;
    border-radius: 20px;
    background-color: #fff;
    box-shadow: 0 4px 13px rgba(0, 0, 0, 0.05);
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 30px 15px;
    min-height: 450px;
    position: relative;
    overflow: hidden;
  }

  .cg_tariff_free {
    background-color: #F7F3FF;
    border: 1px solid #F0F0F0;
  }

  .cg_tariff_free .cg_tariff__count {
    margin-bottom: 45px;
    text-transform: inherit;
    font-weight: 600;
  }

  .cg_tariff__title {
    font-size: 22px;
    color: #8a60ff;
    font-weight: 700;
    align-self: flex-start;
    margin-bottom: 28px;
    text-transform: uppercase;
  }

  .cg_tariff__info {
    flex: 1;
  }

  .cg_tariff__item {
    display: flex;
    margin-bottom: 10px;
  }

  .cg_tariff__icon {
    padding-top: 4px;
  }

  .cg_tariff__item-group {
    padding-left: 9px;
  }

  .cg_tariff__item-title {
    font-size: 16px;
    line-height: 22px;
    margin: 0;
  }

  .cg_tariff__desc {
    opacity: .4;
  }

  .cg_tariff__count {
    color: #28a745;
    font-size: 17px;
    font-weight: 700;
    align-self: flex-start;
    text-transform: uppercase;
    padding-left: 18px;
    margin: 30px 0;
  }

  .cg_tariff__connect {
    width: 85%;
  }

  .cg_tariff__connect .btn {
    width: 100%;
    font-size: 14px;
    padding: 10px;
    border-radius: 50px;
    margin: 0 auto;
    text-decoration: none;
  }

  .cg_tariff__connect .btn:hover {
    color: #fff;
  }

  .cg_tariffs__calculate {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 20px;
  }

  .cg_tariffs__calculate p,
  .cg_tariffs__calculate h2 {
    margin: 0;
  }

  .cg_tariffs__calculate-form {
    width: 100%;
    max-width: 400px;
    display: flex;
    flex-direction: row;
    align-items: center;
  }

  .cg_special_tariff {
    border: 1px solid #8a60ff;
    border-radius: 20px;
    background-color: #ffffff;
    box-shadow: 0 4px 13px rgba(0, 0, 0, 0.05);
    position: relative;
    padding: 30px 40px;
    z-index: 1;
    overflow: hidden;
    margin-top: 20px;
    grid-column: 1/-1;
  }

  .cg_special_tariff::after {
    display: block;
    position: absolute;
    right: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-image: url(<?php echo str_replace('/compiled/', '/', plugins_url('/assets/images/tariffs/special.png', __FILE__)); ?>);
    background-repeat: no-repeat;
    background-size: 620px;
    background-position: 104% 41%;
    content: "";
    z-index: -1;
  }

  @media screen and (max-width: 1199px) {
    .cg_special_tariff::after {
      background-position: 200% 41%;
    }
  }

  @media screen and (max-width: 991px) {
    .cg_special_tariff::after {
      content: unset;
    }
  }

  .cg_special_tariff__title {
    color: #8a60ff;
    font-size: 20px;
    font-weight: 800;
    margin-bottom: 10px;
  }

  .cg_special_tariff__info {
    flex: 1;
  }

  .cg_special_tariff__item {
    display: flex;
  }

  .cg_special_tariff__icon {
    padding-top: 4px;
  }

  .cg_special_tariff__item-group {
    padding-left: 9px;
  }

  .cg_special_tariff__item-title {
    font-size: 16px;
    line-height: 22px;
    margin: 0;
  }

  .cg_special_tariff__count {
    color: #28a745;
    font-size: 17px;
    font-weight: 700;
    align-self: flex-start;
    text-transform: uppercase;
    padding-left: 18px;
    margin: 30px 0;
  }

  .cg_special_tariff__connect .btn {
    max-width: 200px;
    width: 100%;
    font-size: 14px;
    padding: 10px;
    border-radius: 50px;
    text-decoration: none;
  }

  .cg_special_tariff__connect .btn:hover {
    color: #fff;
  }

  .cg_warning-tariff-modal .cg_modal-header {
    justify-content: flex-end;
    align-items: center;
    border-bottom: 0;
  }

  .cg_warning-tariff-modal.cg_modal-mask .modal-container {
    max-width: 600px;
  }

  .cg_warning-tariff-modal.cg_modal-mask .cg_modal-container .cg_modal-body {
    padding: 0 40px 24px;
  }

  .cg_warning-tariff-modal.cg_modal-mask .cg_modal-container .cg_modal-body p {
    max-width: 410px;
    margin: 0 auto 15px;
    text-align: center;
    font-size: 16px;
    line-height: 19px;
  }

  .cg_warning-tariff-modal.cg_modal-mask .cg_modal-container .cg_modal-body button {
    display: block;
    max-width: 230px;
    width: 100%;
    border-radius: 50px;
    margin: 55px auto 0;
  }
</style>
