<?php $cg_id = random_int(1, 99999999999) ?>

<div class="widget-text wp_widget_plugin_box">
    @if($cg_widget_format)
        <div class="wp_widget_plugin_box__format"
             style="width: {{$cg_widget_width}}px;"
        >
            <div class="wp_widget_plugin_box__iframe"
                 style="width: {{$cg_widget_width}}px; height: {{$cg_widget_height}}px;"
            >
                <iframe src="{{$cg_widget_link}}?play=true"></iframe>
            </div>

            <div class="wp_widget_plugin_box__desc">{{$cg_widget_desc}}</div>
        </div>
    @else
        <div class="wp_widget_plugin_box__wrapper"
             onclick="cg_handleClick({cg_widget_display: {{$cg_widget_display}}, cg_widget_link: '{{$cg_widget_link}}', cg_id: '{{$cg_id}}'})"
        >
            @if(isset($cg_widget_bg))
                <img src="{{$cg_widget_bg}}" alt="Game's banner">
            @else
                <div class="wp_widget_plugin_box__default">
                    <img src="<?php echo str_replace('/compiled/', '/', plugins_url('/assets/images/dummy-plug.png', __FILE__)); ?>" alt="Here will be your banner">
                </div>
            @endif

            <div class="wp_widget_plugin_box__iframe-container" data-id="{{$cg_id}}"></div>
        </div>
    @endif
</div>

<script>
  var cg_handleClick = (data) => {
    if(data.cg_widget_display === 0) {
      window.open(data.cg_widget_link, '_blank');
    } else if(data.cg_widget_display === 1) {
      _render([data], `.wp_widget_plugin_box__iframe-container[data-id="${ data.cg_id }"]`, templateIframe);
    } else if(data.cg_widget_display === 2) {
      _render([data], `body`, templateModalWindow, true);
    }
  };

  var templateIframe = (data) => {
    return `
        <div class="wp_widget_plugin_box__iframe">
            <iframe src="${ data.cg_widget_link }"></iframe>
        </div>
    `;
  };

  var templateModalWindow = (data) => {
    return `
        <div class="wp_widget_plugin_box__modal">
            <div class="wp_widget_plugin_box__modal-wrapper" onclick="closeModal()"></div>
            <div class="wp_widget_plugin_box__modal-container">
                <span class="wp_widget_plugin_box__modal-close" onclick="closeModal()">×</span>

                <div class="wp_widget_plugin_box__modal-body">
                    <div class="wp_widget_plugin_box__modal-iframe">
                        <iframe src="${ data.cg_widget_link }"></iframe>
                    </div>
                </div>
            </div>
        </div>
    `;
  };

  var _render = (data, selector, template, add = false) => {
    var block = document.querySelector(`${ selector }`);
    if(!add) {
      block.innerHTML = '';

      if(data) {
        data.forEach((item, index) => block.innerHTML += template(item, index));
      } else {
        block.innerHTML = template();
      }
    } else {
      data.forEach((item, index) => block.innerHTML += template(item, index));
    }
  };

  var closeModal = () => {
    var modal = document.querySelector('.wp_widget_plugin_box__modal');
    modal.remove();
  };
</script>

<style>
  .wp_widget_plugin_box__wrapper {
    position: relative;
    display: flex;
    cursor: pointer;
  }

  .wp_widget_plugin_box__wrapper img {
    max-width: 100%;
  }

  .wp_widget_plugin_box__default {
    display: flex;
  }

  .wp_widget_plugin_box {
    position: relative;
  }

  .wp_widget_plugin_box__modals {
    margin: 0;
    padding: 0;
    position: absolute;
    z-index: 99999999999;
    left: 0;
    top: 0;
  }

  .wp_widget_plugin_box__modal {
    display: flex;
    align-items: center;
    position: fixed;
    left: 0;
    top: 0;
    height: 100vh;
    width: 100vw;
    padding: 20px;
    background-color: rgba(0, 0, 0, .5);
    transition: opacity .3s ease;
    z-index: 99999999999;
    box-sizing: border-box;
  }

  .wp_widget_plugin_box__modal-wrapper {
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 100%;
    z-index: 99999999998;
  }

  .wp_widget_plugin_box__modal-container {
    position: relative;
    background-color: #fff;
    border-radius: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
    font-family: Montserrat, Helvetica, Arial, sans-serif;
    margin: 0 auto;
    transition: all .3s ease;
    z-index: 99999999999;
    width: 90%;
    height: 90%;
  }

  .wp_widget_plugin_box__modal-close {
    position: absolute;
    display: flex;
    align-items: center;
    justify-content: center;
    right: -17px;
    top: -17px;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    font-size: 24px;
    line-height: 24px;
    color: #fff;
    cursor: pointer;
    outline: none;
    border: none;
    background-color: #8a60ff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
    padding: 0;
    transition: all .25s linear;
  }

  .wp_widget_plugin_box__modal-close:hover {
    background-color: #7a47ff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .5);
    color: #fff;
  }

  .wp_widget_plugin_box__modal-body {
    position: relative;
    height: 100%;
    width: 100%;
    overflow-y: auto;
    padding: 20px;
    box-sizing: border-box;
  }

  .wp_widget_plugin_box__iframe {
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 100%;
  }

  .wp_widget_plugin_box__modal-iframe {
    height: 100%;
    width: 100%;
  }

  .wp_widget_plugin_box__iframe iframe,
  .wp_widget_plugin_box__modal-iframe iframe {
    height: 100%;
    width: 100%;
    border: none;
  }

  .wp_widget_plugin_box__format {
    display: flex;
    flex-direction: column;
    border-radius: 10px;
    overflow: hidden;
  }

  .wp_widget_plugin_box__format .wp_widget_plugin_box__iframe {
    position: relative;
  }

  .wp_widget_plugin_box__desc {
    padding: 15px;
    font-size: 16px;
    border-radius: 0 0 10px 10px;
    background-color: #aaaaaa;
  }
</style>
