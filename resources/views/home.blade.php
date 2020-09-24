@extends('layouts.default')
@section('content')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Blank Page</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Example Card</h4>
                </div>
                <div class="card-body">
                    <div class="image-decorator">
                        <img alt="Image principale" id="example" src="{{URL::asset($url)}}"/>
                    </div>
                    
                    <table>
                        <tr>
                            <td class="actions">
                                <input type="button" id="btnViewRel" value="Display relative" class="actionOn" />
                                
                                <form action="/crop" method="POST" id="modal-form">
                                    @csrf
                                    <input type="hidden" name="items">
                                    <input type="hidden" name="url" value="{{$url}}">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
                                    </button>

                                </form>
                            </td>
                            <td>
                                <div id="output" class='output'> </div>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <div class="card-footer bg-whitesmoke">
                    This is card footer
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">


			$(document).ready(function () {
				$('img#example').selectAreas({
					minSize: [10, 10],
					onChanged: insertToInput,
					width: 500
				});
				$('#btnViewRel').click(function () {
                    var areas = $('img#example').selectAreas('relativeAreas');
                    console.log(areas);
					displayAreas(areas);
				});

			});
            

			var selectionExists;

            function areaToString (area) {
                return (typeof area.id === "undefined" ? "" : (area.id + ": ")) + area.x + ':' + area.y  + ' ' + area.width + 'x' + area.height + '<br />'
            }

            function output (text) {
                $('#output').html(text);
            }
            // Display areas coordinates in a div
            function displayAreas (areas) {
                var text = "";
                $.each(areas, function (id, area) {
                    text += areaToString(area);
                });
                output(text);
            };

            function insertToInput() {
                var coordinate = $('img#example').selectAreas('relativeAreas');
                coordinate = JSON.stringify(coordinate);
                $("input[name=items]").val(coordinate);
            }
</script>

@stop