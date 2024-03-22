<div class="cg_choice_game">
    <p class="cg_choice_game__subtitle">
        Select a game from the list for the game entry form. Your logo will be inserted into the game, and you also need
        to add prizes that will drop out to participants after completing the game.
    </p>
    <div class="cg_games">
        <div class="cg_games__list"></div>

        <ul class="cg_pagination"></ul>
    </div>
</div>

<script>
  var _PAGE = 1;

  var preview = (youtube_code) => {
    _render([{ youtube_code }], 'cg_create_game_modal', templatePreviewYoutube);
  };
  var
      templateGame = (data) => {
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
                                onclick="nextStep({name: 'choicegame', id: ${ data.id }})"
                        >
                            Choose
                        </button>

                        <button
                                class="btn outline purple rounded-pill"
                                onclick="preview('${ data.youtube_code }')"
                        >
                            Preview
                        </button>
                    </div>
                </div>
            </div>
        `;
      },
      templatePreviewYoutube = (data) => {
        return `
            <div class="cg_modal-mask">
                <div class="cg_modal-wrapper" onclick="closeModal()"></div>
                <div class="cg_modal-container cg_modal-container__youtube">
                    <div class="cg_modal-body cg_modal-body__youtube">
                        <iframe
                            src="https://www.youtube.com/embed/${ data.youtube_code }"
                            allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture'
                            allowfullscreen
                            frameborder="0"
                            class="cg_modal-iframe__youtube"
                        ></iframe>
                    </div>
                </div>
            </div>
        `;
      },
      templatePagination = (data) => {
        return `
            <div
                class="cg_page-item ${ data.active ? 'cg_active' : '' }"
                onclick="getGames('cgsrv_get_games', '${ data.label }', 20, null)"
            >
                ${ data.label === 'pagination.previous' ? '&#8678;' : data.label === 'pagination.next' ? '&#8680;' : data.label }
            </div>
        `;
      };

  const getGames = (action, page = 1, per_page = 20, ...args) => {
    const formData = new FormData();
    formData.append('action', action);
    formData.append('cg_page', String(page));
    formData.append('cg_per_page', String(per_page));

    if(args.length) {
      for(const prop in args[0]) {
        formData.append(prop, args[0][prop]);
      }
    }

    const data = {};
    formData.forEach((value, key) => data[key] = value);

    jQuery.ajax({
      type: 'POST',
      url: '/wp-admin/admin-post.php',
      data: data,
      success: function(res) {
        const response = JSON.parse(res);
        const data = response?.data;
        const links = response?.meta?.links;

        _PAGE = page;

        _render(data, 'cg_games__list', templateGame);
        _render(links, 'cg_pagination', templatePagination);
      }
    });
  };

  getGames('cgsrv_get_games');
</script>

<style>
  @include('../assets/app.css')

  .cg_choice_game {
    margin-top: 50px;
  }

  .cg_games {
    display: flex;
    flex-direction: column;
  }

  .cg_games__list {
    align-items: center;
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
  }

  .cg_game {
    border-radius: 18px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, .05);
    padding: 28px 25px;
    width: 270px;
    box-sizing: border-box;
    align-items: center;
    display: flex;
    flex-direction: column;
  }

  .cg_choice_game__subtitle {
    font-size: 16px;
    line-height: 20px;
    color: #000;
    max-width: 500px;
    margin: 0 0 75px 0;
  }

  .cg_game__image {
    height: 210px;
    width: 210px;
  }

  .cg_game__image_img {
    height: 100%;
    object-fit: contain;
    width: 100%;
  }

  .cg_game__info {
    margin-top: 25px;
    width: 100%;
  }

  .cg_game__title {
    text-align: center;
    color: #303030;
    font-size: 20px;
    font-weight: 700;
    height: 48px;
    line-height: 24px;
  }

  .cg_game__buttons {
    margin-top: 14px;
    align-items: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 10px;
  }

  .cg_game__buttons .btn {
    width: 100%;
  }

  .cg_modal-container.cg_modal-container__youtube {
    width: 100%;
    max-width: 77vw;
    max-height: 45vw;
    height: 100%;
  }

  .cg_modal-body.cg_modal-body__youtube {
    overflow: hidden;
    padding: 20px;
  }

  iframe.cg_modal-iframe__youtube {
    border-radius: 20px;
  }

  .cg_pagination {
    box-shadow: 0 4px 4px rgba(0, 0, 0, .25);
    margin: 20px auto 0 0;
    display: inline-flex;
  }

  .cg_pagination .cg_page-item {
    cursor: pointer;
    text-align: center;
    background-color: #fff;
    border-top: 1px solid #8a60ff;
    border-bottom: 1px solid #8a60ff;
    border-left: 1px solid #8a60ff;
    color: #8a60ff;
    display: block;
    line-height: 1.25;
    padding: 8px 12px;
    position: relative;
    transition: all .25s linear;
  }

  .cg_pagination .cg_page-item:first-child {
    border-radius: 4px 0 0 4px;
  }

  .cg_pagination .cg_page-item:last-child {
    border-right: 1px solid #8a60ff;
    border-radius: 0 4px 4px 0;
  }

  .cg_pagination .cg_page-item.cg_active {
    background-color: #8a60ff;
    border-color: #8a60ff;
    color: #fff;
  }

  .cg_page-item:hover {
    background-color: #e9ecef;
    border-color: #dee2e6 !important;
    color: #8a60ff;
    z-index: 2;
  }
</style>
