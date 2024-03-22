<div>
    <table>
        <tr>
            <td>Choose the format of how to open the game on the site</td>
        </tr>
        <tr>
            <td>
                <label>
                    <input class="widefat" type="radio" id="{{$cg_widget_format['id']}}"
                           name="{{$cg_widget_format['name']}}" value="0"
                           @if($cg_widget_format['value'] == '0')
                               checked
                            @endif
                    />
                    Display banner first. When you click on the banner, the game will open (you will need to choose how
                    to open the game: in a pop-up, inside the banner or in a new tab)
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    <input class="widefat" type="radio" id="{{$cg_widget_format['id']}}"
                           name="{{$cg_widget_format['name']}}" value="1"
                           @if($cg_widget_format['value'] == '1')
                               checked
                            @endif
                    />
                    Display the game immediately. Users will not have a banner with a call to action.
                </label>
            </td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td>
                <label>
                    Specify the game that will open when clicking on the banner. Paste the link (if the game is not
                    created, go to the “Game Settings” on the plugin):
                    <input class="widefat" type="text" id="{{$cg_widget_link['id']}}" name="{{$cg_widget_link['name']}}"
                           value="{{$cg_widget_link['value']}}" />
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    Paste the background image URL here. You can upload Your background image to the cloud and paste its
                    URL here, or use Elementor page builder to select it from media center:
                    <input class="widefat" type="text" id="{{$cg_widget_bg['id']}}" name="{{$cg_widget_bg['name']}}"
                           value="{{$cg_widget_bg['value']}}" />
                </label>
            </td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td>Choose how to open the game?</td>
        </tr>
        <tr>
            <td>
                <label>
                    <input class="widefat" type="radio" id="{{$cg_widget_display['id']}}"
                           name="{{$cg_widget_display['name']}}" value="0"
                           @if($cg_widget_display['value'] == '0')
                               checked
                            @endif
                    />
                    Open a new page with the game when clicking on the banner
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    <input class="widefat" type="radio" id="{{$cg_widget_display['id']}}"
                           name="{{$cg_widget_display['name']}}" value="1"
                           @if($cg_widget_display['value'] == '1')
                               checked
                            @endif
                    />
                    Open a popup with a game when clicking on a banner
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    <input class="widefat" type="radio" id="{{$cg_widget_display['id']}}"
                           name="{{$cg_widget_display['name']}}" value="2"
                           @if($cg_widget_display['value'] == '2')
                               checked
                            @endif
                    />
                    Open the game inside the banner (note that if you have a small banner size, the game will open in
                    the same window)
                </label>
            </td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td>Set the size of the playing field (the game will open at the given scale)</td>
        </tr>
        <tr>
            <td>
                <label>
                    width
                    <input class="widefat" type="number" id="{{$cg_widget_width['id']}}"
                           name="{{$cg_widget_width['name']}}" value="{{$cg_widget_width['value']}}">
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    height
                    <input class="widefat" type="number" id="{{$cg_widget_height['id']}}"
                           name="{{$cg_widget_height['name']}}" value="{{$cg_widget_height['value']}}">
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    Enter the text that we will display along with the game.
                    <br>
                    For example, “Play and get a prize with a 30% discount”
                    <textarea class="widefat" id="{{$cg_widget_desc['id']}}"
                              name="{{$cg_widget_desc['name']}}">{{$cg_widget_desc['value']}}</textarea>
                </label>
            </td>
        </tr>
    </table>
</div>
