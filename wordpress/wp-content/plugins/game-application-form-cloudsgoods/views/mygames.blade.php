<section class="cg_my-games">
    <h1 class="h1 cg_my-games__title" data-lang="cg_my-games_title">MY GAMES</h1>

    <div class="cg_my-games__list"></div>

    <div class="cg_my-games__modal"></div>

    @include('../assets/include/pagination.blade.php')
</section>

<script>
  const action = 'cgsrv_get_game_stock';
  const loadingBlock = 'cg_my-games__list';
  const options = null;
  const headers = {
    emails: 'Number of collected email contacts',
    phones: 'Number of collected phone numbers',
    players: 'Number of visitors who played the game',
    referals: 'Number of referred users by other players',
  };

  const
      template = (data) => {
        return `
        <div class="cg_my-games__item">
            <div class="cg_my-games__item-image">
                <!--These are dynamically added pictures, and we get them through the API. Therefore, we cannot transfer them to plugin files.-->
                <img alt="${ data.title }" src="https://cloudsgoods.com${ data.landing_photo_mobile_group }">
            </div>

            <div class="cg_my-games__item-content">
                ${ data.status === 'created' ? `
                    <div class="cg_my-games__item-draft">Draft</div>
                ` : data.status === 'active' ? `
                    <div class="cg_my-games__item-draft cg_my-games__item-draft_active">Active</div>
                ` : data.status === 'pause' ? `
                    <div class="cg_my-games__item-draft cg_my-games__item-draft_pause">Pause</div>
                ` : data.status === 'closed' ? `
                    <div class="cg_my-games__item-draft cg_my-games__item-draft_closed">Completed</div>
                ` : `` }


                <div class="cg_my-games__item-name">Game: ${ data.title }</div>
                    <p class="cg_my-games__item-created">
                        <span>
                            Creation Date:
                            ${ new Date(data.create_date * 1000).toLocaleString('ru-RU') }
                            <i>id: ${ data.id }</i>
                        </span>
                    </p>

                    <p class="cg_my-games__item-created">
                        <span>
                            Completion Date:
                            ${ new Date(data.end_date * 1000).toLocaleString('ru-RU') }
                        </span>
                    </p>

                <div class="cg_my-games__copy">
                  <a href="${ data.short_link_num }" target="_blank" class="cg_my-games__item-link">${ data.short_link_num }</a>
                  <button type="button" class="btn purple" onclick="onCopyLink('${ data.short_link_num }')">Copy</button>
                </div>

            </div>

            <div class="cg_my-games__item-settings">
                <div class="cg_my-games__item-actions">
                        <button class="cg_my-games__item-action btn purple" onclick="previewGame(${ data.id })">View</button>
                        ${ data.status === 'created' ? `
                             <button class="cg_my-games__item-action btn purple outline" onclick="openModalChangeGame(${ data.id })">Replace the game</button>
                        ` : data.status === 'pause' ? `
                            <button class="cg_my-games__item-action btn purple outline" onclick="statusGame('active', ${ data.id })">Start</button>
                        ` : data.status === 'active' ? `
                            <button class="cg_my-games__item-action btn purple outline" onclick="statusGame('pause', ${ data.id })">Pause</button>
                        ` : `` }

                        <div class="cg_menu-button" id="cg_menu-button_${ data.id }"
                             onclick="openMenu(${ data.id })">&#9776;
                        </div>

                        <div class="cg_dropdown" id="cg_dropdown_${ data.id }">
                            <ul>
                                <li onclick="editGame(${ data.id })">Edit</li>
                                <li onclick="removeGame(${ data.id })">Delete</li>
                                ${ data.status === 'created' ? `
                                    <li onclick="statusGame('active', ${ data.id })">Start</li>
                                ` : data.status === 'active' ? `
                                    <li onclick="postGame(${ data.id })">Posting the game</li>
                                ` : `` }
                                <li onclick="copyGame(${ data.id })">Copy</li>
                                <li onclick="statisticGame(${ data.id })">Statistics</li>
                            </ul>
                        </div>
                    </div>
            </div>
        </div>
    `;
      },
      templateModalChangeGame = () => {
        return `
            <div class="cg_modal-mask">
                <div class="cg_modal-wrapper" onclick="closeModal()"></div>
                <div class="cg_modal-container cg_upload_good_container">
                    <div class="cg_modal-header">
                        <div class="title">Game templates</div>
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
                                onclick="changeGame('${ data.id }', '${ data.game_id }')"
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
      templateModalPreviewGame = (data) => {
        return `
            <div class="cg_modal-mask">
                <div class="cg_modal-wrapper" onclick="closeModal()"></div>
                <div class="cg_modal-container cg_upload_good_container">
                    <div class="cg_modal-header">
                        <div class="title">Game preview</div>
                        <button type="button" class="cg_close" onclick="closeModal()">×</button>
                    </div>
                    <div class="cg_modal-body cg_modal-body_preview">
                        <div class="cg_preview-game">
                            <div class="cg_preview-game__iframe">
                                <iframe src="https://cloudsgoods.com/game/${ data.id }"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
      },
      templateModalIframeGame = (data) => {
        return `
            <div class="cg_modal-mask">
                <div class="cg_modal-wrapper" onclick="closeModal('${ data.status }')"></div>
                <div class="cg_modal-container cg_iframe_modal">
                    <div class="cg_modal-header">
                        <div class="title">${ data.title }</div>
                        <button type="button" class="cg_close" onclick="closeModal('${ data.status }')">×</button>
                    </div>
                    <div class="cg_modal-body cg_modal-body_preview">
                        <div class="cg_iframe-wrapper">
                            <div class="cg_preview-game__iframe"></div>
                        </div>
                    </div>
                </div>
            </div>
        `;
      },
      templateModalIframePostGame = (data) => {
        return `
            <iframe src="https://cloudsgoods.com/loyalty/setup/${ data.id }?token={{$token}}"></iframe>
        `;
      },
      templateModalIframeEditGame = (data) => {
        return `
            <iframe src="https://cloudsgoods.com/loyalty/settinggame/${ data.id }?token={{$token}}"></iframe>
        `;
      },
      templateModalWarning = () => {
        return `
            <div class="cg_modal-mask cg_warning-tariff-modal">
              <div class="cg_modal-wrapper" onclick="closeModal()"></div>
              <div class="cg_modal-container">
                  <div class="cg_modal-header">
                      <button type="button" class="cg_close" onclick="closeModal()">×</button>
                  </div>
                  <div class="cg_modal-body">
                      <p>Please note that only 2 games can be active at the same time on the unlimited plan.</p>
                      <p>Please pause one of the games and then restart this game.</p>
                      <button class="btn purple" type="button" onclick="closeModal()">Close</button>
                  </div>
              </div>
            </div>
          `;
      },
      templateModalStatistic = () => {
        return `
            <div class="cg_modal-mask">
                <div class="cg_modal-wrapper" onclick="closeModal()"></div>
                <div class="cg_modal-container">
                    <div class="cg_modal-header">
                        <div class="title">Game statistics</div>
                        <button type="button" class="cg_close" onclick="closeModal()">×</button>
                    </div>
                    <div class="cg_modal-body">
                        <div class="cg_modal-statistic"></div>
                    </div>
                </div>
            </div>
        `;
      },
      templateModalStatisticTableTr = (data) => {
        return `
            <div class="cg_modal-statistic__tr">
                <div class="cg_modal-statistic__td">${ data.title }</div>
                <div class="cg_modal-statistic__td">${ data.value }</div>
            </div>
        `;
      };

  const
      previewGame = (id) => {
        _render([{ id }], 'cg_my-games__modal', templateModalPreviewGame);
      },
      changeGame = (cg_game_id, cg_game_stock_id) => {
        const data = {
          action: 'cgsrv_edit_game_stock',
          cg_game_id,
          cg_game_stock_id
        };

        jQuery.ajax({
          type: 'POST',
          url: '/wp-admin/admin-post.php',
          data: data,
          success: function() {
            getData(action);
            closeModal();
          }
        });
      },
      removeGame = (cg_game_stock_id) => {
        const data = {
          action: 'cgsrv_del_game_stock',
          cg_game_stock_id
        };

        jQuery.ajax({
          type: 'POST',
          url: '/wp-admin/admin-post.php',
          data: data,
          success: function() {
            getData(action);
          }
        });
      },
      statusGame = (cg_game_status, cg_game_stock_id) => {
        if(_CG_PACKAGE_TARIFF_ID === 5 && _CG_ACTIVE_GAMES > 1 && cg_game_status === 'active') {
          _render(null, 'cg_my-games__modal', templateModalWarning);
        } else {
          jQuery.ajax({
            type: 'POST',
            url: '/wp-admin/admin-post.php',
            data: {
              action: 'cgsrv_edit_game_stock',
              cg_game_status,
              cg_game_stock_id
            },
            success: function() {
              getData(action);
            }
          });
        }
      },
      editGame = (id) => {
        _render([{ status: 'edit', title: 'Game edit' }], 'cg_my-games__modal', templateModalIframeGame);
        _render([{ id }], 'cg_preview-game__iframe', templateModalIframeEditGame);
      },
      postGame = (id) => {
        _render([{ status: 'post', title: 'Replace the game' }], 'cg_my-games__modal', templateModalIframeGame);
        _render([{ id }], 'cg_preview-game__iframe', templateModalIframePostGame);
      },
      copyGame = (cg_game_stock_id) => {
        const data = {
          action: 'cgsrv_copy_game_stock',
          cg_game_stock_id
        };

        jQuery.ajax({
          type: 'POST',
          url: '/wp-admin/admin-post.php',
          data: data,
          success: function() {
            getData(action);
          }
        });
      },
      statisticGame = (cg_game_stock_id) => {
        jQuery.ajax({
          type: 'POST',
          url: '/wp-admin/admin-post.php',
          data: {
            action: 'cgsrv_get_game_statistics',
            cg_game_stock_id
          },
          success: function(res) {
            const response = JSON.parse(res).data;
            const data = Object.keys(response)
                .map(i => {
                  return {
                    title: headers[i],
                    value: response[i],
                  };
                });

            _render(null, 'cg_my-games__modal', templateModalStatistic);
            _render(data, 'cg_modal-statistic', templateModalStatisticTableTr);
          }
        });
      };

  const onCopyLink = (link) => {
    navigator.clipboard.writeText(link);
  };

  const openModalChangeGame = (game_id) => {
    const formData = new FormData();
    formData.append('action', 'cgsrv_get_games');
    formData.append('cg_page', '1');
    formData.append('cg_per_page', '1000');

    console.log(game_id);

    const data = {};
    formData.forEach((value, key) => data[key] = value);

    jQuery.ajax({
      type: 'POST',
      url: '/wp-admin/admin-post.php',
      data: data,
      success: function(res) {
        const arr = JSON.parse(res).data.map(item => {
          return {
            ...item,
            game_id
          };
        });
        _render(null, 'cg_my-games__modal', templateModalChangeGame);
        _render(arr, 'cg_preview_change_game', templateModalChangeGameItem);
      }
    });
  };

  const
      openMenu = (id) => {
        const dropdown = document.querySelector(`#cg_dropdown_${ id }`);
        if(dropdown.classList.contains('cg_dropdown_active')) {
          dropdown.classList.remove('cg_dropdown_active');
        } else {
          dropdown.classList.add('cg_dropdown_active');
        }

        clickOutsideMenu(id);
      },
      clickOutsideMenu = (id) => {
        const button = document.querySelector(`#cg_menu-button_${ id }`);
        const dropdown = document.querySelector(`#cg_dropdown_${ id }`);

        document.addEventListener('click', e => {
          let target = e.target;
          let its_menu = target === dropdown || dropdown.contains(target);
          let its_hamburger = target === button;
          let menu_is_active = dropdown.classList.contains('cg_dropdown_active');

          if(!its_menu && !its_hamburger && menu_is_active) {
            dropdown.classList.remove('cg_dropdown_active');
          }
        });
      },
      closeModal = (status) => {
        const modal = document.querySelector('.cg_modal-mask');
        modal.remove();

        if(status === 'edit') {
          getData(action);
        } else if(status === 'post') {
          console.log('Post game');
        }
      };
</script>

<style>
  @include('../assets/app.css')

  .cg_my-games {
    padding-right: 20px;
  }

  @media (max-width: 782px) {
    .cg_my-games {
      padding-right: 10px;
    }
  }

  .cg_my-games__list {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .cg_my-games__item {
    display: flex;
    gap: 30px;
    position: relative;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #c4c4c4;
    border-radius: 24px;
  }

  .cg_my-games__item-image {
    display: flex;
    width: 115px;
    height: 115px;
  }

  .cg_my-games__item-image img {
    height: 100%;
    width: 100%;
    border-radius: 24px;
    object-fit: cover;
  }

  .cg_my-games__item-content {
    display: flex;
    flex-direction: column;
    /*justify-content: space-between;*/
  }

  .cg_my-games__item-draft {
    position: absolute;
    right: 20px;
    top: 20px;
    background-color: #343a40;
    color: #fff;
    padding: 8px 24px;
    text-transform: uppercase;
    border-radius: 4px;
  }

  .cg_my-games__item-draft_active {
    background-color: #28a745;
  }

  .cg_my-games__item-draft_pause {
    background-color: #6c757d;
  }

  .cg_my-games__item-draft_closed {
    background-color: #4b5157;
  }

  .cg_my-games__item-name {
    color: #303030;
    font-size: 18px;
    font-weight: 700;
    line-height: 20px;
    margin-bottom: 10px;
  }

  .cg_my-games__item-created {
    color: #c4c4c4;
    margin: 0;
  }

  .cg_my-games__item-link {
    color: #8a60ff;
    transition: all .25s linear;
  }

  .cg_my-games__item-link:hover {
    color: #8a60ff;
    text-decoration-color: transparent;
  }

  .cg_my-games__item-timer {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .cg_my-games__item-timer .ended {
    color: #303030;
    font-size: 11px;
    line-height: 14px;
  }

  .cg_my-games__item-timer .timer {
    align-items: center;
    display: flex;
    gap: 10px;
    justify-content: space-between;
    max-width: 200px;
    width: 100%;
  }

  .cg_my-games__item-timer .timer .item {
    flex: 1;
    text-align: center;
  }

  .cg_my-games__item-timer .timer .item .title {
    font-size: 9px;
    color: #474747;
    display: block;
    text-align: center;
    font-weight: 700;
  }

  .cg_my-games__item-timer .timer .item .count {
    align-items: center;
    border: 1px solid #8a60ff;
    border-radius: 5px;
    color: #8a60ff;
    display: flex;
    font-size: 11px;
    height: 24px;
    justify-content: center;
    line-height: 14px;
  }

  .cg_my-games__item-settings {
    margin-left: auto;
    display: flex;
    align-items: flex-end;
  }

  .cg_my-games__item-actions {
    align-items: center;
    position: relative;
    cursor: pointer;
    display: flex;
    gap: 30px;
    justify-content: flex-end;
  }

  .cg_my-games__item-action {
    min-width: 150px;
    font-size: 15px;
  }

  .cg_menu-button {
    font-size: 20px;
    background-color: #f7f7f7;
    border-radius: 10px;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all .25s linear;
  }

  .cg_menu-button:hover {
    background-color: #d9d9d9;
  }

  .cg_dropdown {
    opacity: 0;
    pointer-events: none;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 13px rgba(0, 0, 0, .11);
    right: 0;
    padding: 5px 0;
    position: absolute;
    top: 50px;
    width: 200px;
    z-index: 2;
    transition: opacity .25s linear;
  }

  .cg_dropdown_active {
    opacity: 1;
    pointer-events: auto;
  }

  .cg_dropdown li {
    color: #000;
    display: flex;
    align-items: center;
    height: 40px;
    padding: 0 20px;
    cursor: pointer;
    background-color: transparent;
    transition: background-color .25s linear;
  }

  .cg_dropdown li:hover {
    background-color: #c4c4c4;
  }

  .cg_preview_change_game {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    gap: 10px;
    padding: 20px;
  }

  .cg_iframe_modal {
    max-width: 1000px;
    width: 100%;
  }

  .cg_iframe-wrapper {
    height: 100vh;
    max-height: 800px;
    width: 100%;
  }

  .cg_modal-body.cg_modal-body_preview {
    max-height: 840px;
  }

  .cg_my-games__copy {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-top: auto;
  }

  .cg_my-games__copy .btn {
    height: 30px;
    font-size: 12px;
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

  .cg_modal-statistic {
    display: flex;
    flex-direction: column;
    gap: 5px;
    max-width: 600px;
    width: 100vw;
  }

  .cg_modal-statistic__tr {
    background-color: #ffffff;
    box-shadow: 0 1px 0 rgba(0, 0, 0, 0.11);
    border-radius: 10px;
    padding: 10px 30px;
    display: grid;
    grid-template-columns: 2fr 1fr;
    grid-gap: 2rem;
    color: #000;
    font-size: 14px;
    line-height: 17px;
    align-items: center;
  }

  .cg_modal-statistic__td:first-child {
    text-align: left;
  }

  .cg_modal-statistic__td:last-child {
    text-align: center;
  }
</style>
