<div class="cg_preview_game">
    <h1>GAME PREVIEW</h1>

    <div class="cg_preview_game_wrapper">
        <div class="picture desktop mac-iframe"></div>

        <div class="picture mobile iphone-iframe"></div>
    </div>

    <div class="cg_preview_game_change">
        <button class="btn purple" type="button" onclick="openModalChangeGame()">Replace the game</button>
    </div>

    <div class="cg_preview_game_launch">
        <button class="btn purple outline" type="button" onclick="launchGame()">START</button>
    </div>
</div>

<script>
  var
      cg_game = null,
      _CG_PACKAGE_TARIFF_ID = 0,
      _CG_ACTIVE_GAMES = 0;

  var
      templateModalChangeGame = () => {
        return `
            <div class="cg_modal-mask">
                <div class="cg_modal-wrapper" onclick="closeModal()"></div>
                <div class="cg_modal-container cg_upload_good_container">
                    <div class="cg_modal-header">
                        <div class="title">Game Templates</div>
                        <button type="button" class="cg_close" onclick="closeModal()">×</button>
                    </div>
                    <div class="cg_modal-body cg_preview_change_game"></div>
                </div>
            </div>
        `;
      },
      templateModalChangeGameItem = (data) => {
        return `
            <div class="cg_game">
                <div class="cg_game__image">
                    <img
                            src="${ data.game_photo_uri }"
                            alt="${ data.title }"
                            class="cg_game__image_img"
                    >
                </div>

                <div class="cg_game__info">
                    <h3 class="cg_game__title">${ data.title }</h3>
                    <div class="cg_game__buttons">
                        <button
                                class="btn purple rounded-pill"
                                onclick="changeGame('${ data.id }')"
                        >
                            Choose
                        </button>

                        <button
                                class="btn outline purple rounded-pill"
                                onclick="preview({id: ${ data.id }})"
                        >
                            Preview
                        </button>
                    </div>
                </div>
            </div>
        `;
      },
      templateModalLaunch = () => {
        return `
            <div class="cg_modal-mask cg_modal-mask__launch">
                <div class="cg_modal-wrapper" onclick="closeModal()"></div>
                <div class="cg_modal-container">
                    <div class="cg_modal-header">
                        <div class="title">SETUP ALMOST COMPLETE</div>
                        <button type="button" class="cg_close" onclick="closeModal()">×</button>
                    </div>
                    <div class="cg_modal-body">
                        <div class="cg_modal-body_content">
                            <p class="cg_modal-empty">There are not enough funds on your balance</p>
                            <p class="cg_modal-notify">THE GAME WILL BE LAUNCHED IN FREE MODE</p>
                            <p class="cg_modal-tariff">Available at this rate:</p>
                            <p class="cg_modal-collect">5 email contacts per day, phone number is unavailable</p>
                        </div>

                        <div class="cg_modal-actions">
                            <button type="button" class="btn purple" onclick="toTariff()">
                                <span>REMOVE RESTRICTIONS</span>
                                <span>from $10 per month</span>
                            </button>

                            <button type="button" class="btn link" onclick="congrats()">CONTINUE FOR FREE</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
      },
      templateModalCongrats = (data) => {
        return `
            <div class="cg_modal-mask cg_modal-mask__congrats">
                <div class="cg_modal-wrapper" onclick="toMyGames()"></div>
                <div class="cg_modal-container">
                    <div class="cg_modal-header">
                        <div class="title">Your game is set up!</div>
                        <button type="button" class="cg_close" onclick="toMyGames()">×</button>
                    </div>
                    <div class="cg_modal-body">
                        <div class="cg_modal-body_content">
                            <p>You can choose to display this game in your widget when setting up. See the instructions on the home page for more information.</p>
                            <p>Check out the game at the link:</p>
                            <a href="${ data.short_link }" target="_blank" class="cg_modal-href">${ data.short_link }</a>
                            <button type="button" class="btn link"  onclick="toMyGames()">GO TO MY GAMES</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
      },
      templateMacIframe = (data) => {
        return `
            <img src="<?php echo str_replace('/compiled/', '/', plugins_url('/assets/images/preview-mac.jpeg', __FILE__)); ?>" alt="">
            <iframe src="https://cloudsgoods.com/game/${ data.id }" id="desktop_iframe"></iframe>
        `;
      },
      templateIphoneIframe = (data) => {
        return `
            <img src="<?php echo str_replace('/compiled/', '/', plugins_url('/assets/images/preview-iphone.jpeg', __FILE__)); ?>" alt="">
            <iframe src="https://cloudsgoods.com/game/${ data.id }" id="mobile_iframe"></iframe>
        `;
      },
      modalTemplate = (data) => {
        return `
            <div class="cg_modal-mask cg_warning-tariff-modal">
              <div class="cg_modal-wrapper" onclick="closeModal()"></div>
              <div class="cg_modal-container">
                  <div class="cg_modal-header">
                      <button type="button" class="cg_close" onclick="closeModal()">×</button>
                  </div>
                  <div class="cg_modal-body">
                      <p>Please note that only 2 games can be active at the same time on the unlimited plan.</p>
                      <p>You already have it activated ${ data.count } games.</p>
                      <p>If you click "Finish Creation" now, this game will be activated and other games will stop, and you will need to start them manually without losing any data.</p>
                      <p>If you don't want to run this game, click on the "Activate Later" button.</p>
                      <div class="actions">
                        <button class="btn purple" type="button" onclick="onStopAllGames()">Complete creation</button>
                        <button class="btn purple outline" type="button" onclick="toMyGames()">Activate later</button>
                    </div>
                  </div>
              </div>
            </div>
          `;
      };

  var
      openModalChangeGame = () => {
        const formData = new FormData();
        formData.append('action', 'cgsrv_get_games');
        formData.append('cg_page', '1');
        formData.append('cg_per_page', '1000');

        const data = {};
        formData.forEach((value, key) => data[key] = value);

        jQuery.ajax({
          type: 'POST',
          url: '/wp-admin/admin-post.php',
          data: data,
          success: function(res) {
            _render(null, 'cg_create_game_modal', templateModalChangeGame);
            _render(JSON.parse(res).data, 'cg_preview_change_game', templateModalChangeGameItem);
          }
        });
      },
      changeGame = (id) => {
        const formData = new FormData();
        formData.append('action', 'cgsrv_edit_game_stock');
        formData.append('cg_game_id', id);
        formData.append('cg_game_stock_id', cg_game.id);

        const data = {};
        formData.forEach((value, key) => data[key] = value);

        jQuery.ajax({
          type: 'POST',
          url: '/wp-admin/admin-post.php',
          data: data,
          success: function(res) {
            localStorage.removeItem('cg_game');
            localStorage.setItem('cg_game', JSON.stringify(JSON.parse(res).data));
            onLoad();
            closeModal();
          }
        });
      },
      launchGame = () => {
        jQuery.ajax({
          type: 'POST',
          url: '/wp-admin/admin-post.php',
          data: {
            action: 'cgsrv_user_limits'
          },
          success: function(res) {
            const response = JSON.parse(res);
            const data = response?.data[0];

            _CG_PACKAGE_TARIFF_ID = data.package_tariff_id;

            jQuery.ajax({
              type: 'POST',
              url: '/wp-admin/admin-post.php',
              data: {
                action: 'cgsrv_games_by_status',
                cg_game_status: 'active'
              },
              success: function(res) {
                const response = JSON.parse(res);
                _CG_ACTIVE_GAMES = response?.meta?.total;

                if(_CG_PACKAGE_TARIFF_ID === 5 && _CG_ACTIVE_GAMES > 1) {
                  _render([{ count: _CG_ACTIVE_GAMES }], 'cg_create_game_modal', modalTemplate);
                } else {
                  jQuery.ajax({
                    type: 'POST',
                    url: '/wp-admin/admin-post.php',
                    data: {
                      action: 'cgsrv_user_limits'
                    },
                    success: function(res) {
                      const game = localStorage.getItem('cg_game');
                      const reg_type = JSON.parse(game).reg_type;
                      const data = JSON.parse(res).data[0];

                      if(data[reg_type + '_account'] > 0) {
                        congrats();
                      } else {
                        _render(null, 'cg_create_game_modal', templateModalLaunch);
                      }
                    }
                  });
                }
              }
            });
          }
        });
      },
      congrats = () => {
        jQuery.ajax({
          type: 'POST',
          url: '/wp-admin/admin-post.php',
          data: {
            action: 'cgsrv_edit_game_stock',
            cg_game_stock_id: cg_game.id,
            cg_game_status: 'active'
          },
          success: function(res) {
            _render([JSON.parse(res).data], 'cg_create_game_modal', templateModalCongrats);
          }
        });
      },
      onStopAllGames = () => {
        jQuery.ajax({
          type: 'POST',
          url: '/wp-admin/admin-post.php',
          data: {
            action: 'cgsrv_closeall_games',
          },
          success: function(res) {
            if(JSON.parse(res)[0]) {
              jQuery.ajax({
                type: 'POST',
                url: '/wp-admin/admin-post.php',
                data: {
                  action: 'cgsrv_edit_game_stock',
                  cg_game_stock_id: cg_game.id,
                  cg_game_status: 'active'
                },
                success: function(res) {
                  _render([JSON.parse(res).data], 'cg_create_game_modal', templateModalCongrats);
                }
              });
            }
          }
        });
      },
      toTariff = () => {
        window.location = '/wp-admin/admin.php?page=cg_menu_adminpagetarif';
      },
      toMyGames = () => {
        window.location = '/wp-admin/admin.php?page=cg_menu_adminpagemygames';
      },
      onLoad = () => {
        cg_game = JSON.parse(localStorage.getItem('cg_game'));
        _render([cg_game], 'mac-iframe', templateMacIframe);
        _render([cg_game], 'iphone-iframe', templateIphoneIframe);
      };

  onLoad();
</script>

<style>
  .cg_preview_game_wrapper {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
  }

  .picture {
    position: relative;
    height: 600px;
    width: 700px;
  }

  .picture img {
    max-height: 550px;
    object-fit: contain;
    width: 100%;
  }

  .picture.desktop iframe {
    height: 375px;
    left: 15px;
    top: 21px;
    width: 670px;
  }

  .picture.mobile iframe {
    border-radius: 10px;
    height: 510px;
    left: 210px;
    top: 19px;
    width: 285px;
  }

  iframe {
    position: absolute;
  }

  .cg_preview_game_change {
    margin-top: 50px;
  }

  .cg_preview_game_launch {
    margin-top: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .cg_preview_game_launch .btn {
    font-size: 25px;
    text-transform: uppercase;
    border-radius: 50px;
    padding: 10px 50px;
    height: unset;
  }

  .cg_modal-container.cg_upload_good_container {
    max-width: 900px;
    width: 100%;
  }

  .cg_modal-container.cg_upload_good_container .cg_preview_change_game {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    gap: 10px;
    padding: 20px;
  }

  .cg_modal-mask__congrats .cg_modal-container,
  .cg_modal-mask__launch .cg_modal-container {
    max-width: 500px;
  }

  .cg_modal-mask__congrats .cg_modal-header {
    font-size: 25px;
    padding: 20px 40px;
  }

  .cg_modal-mask__launch .cg_modal-header {
    font-size: 20px;
    padding: 20px 40px;
  }

  .cg_modal-mask__congrats .cg_modal-body,
  .cg_modal-mask__launch .cg_modal-body {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 30px;
  }

  .cg_modal-mask__congrats .cg_modal-body p {
    font-size: 20px;
    text-align: center;
  }

  .cg_modal-mask__congrats .cg_modal-body_content p:first-child {
    margin: 0;
  }

  .cg_modal-href {
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50px;
    border: 1px solid lightgray;
    padding: 15px 30px;
    font-size: 20px;
    cursor: pointer;
    text-decoration: none;
    transition: background-color .25s linear;
    color: #3c434a;
  }

  .cg_modal-href:hover {
    background-color: lightgray;
  }

  .cg_modal-empty,
  .cg_modal-tariff {
    text-align: center;
    font-size: 17px;
    margin: 0;
  }

  .cg_modal-notify {
    text-transform: uppercase;
    color: #8a60ff;
    font-size: 20px;
    text-align: center;
    font-weight: 700;
    margin: 10px 0;
  }

  .cg_modal-collect {
    font-size: 15px;
    max-width: 350px;
    text-align: center;
    margin: 20px auto 0;
  }

  .cg_modal-actions {
    width: 100%;
    max-width: 300px;
  }

  .cg_modal-actions .btn:first-child {
    width: 100%;
    border-radius: 50px;
    display: flex;
    flex-direction: column;
    align-items: center;
    height: auto;
    padding: 10px 20px;
  }

  .cg_modal-actions .btn:first-child span:last-child {
    font-size: 10px;
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
    width: 100%;
    border-radius: 50px;
  }

  .cg_warning-tariff-modal .actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
  }
</style>
