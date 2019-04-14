@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">Questions
                        <a class="btn btn-primary float-right" style="background-color: mediumblue" href="{{ route('question.create') }}">
{{--                            <a class="btn btn-primary float-right" href="#">--}}
                            Create a Question
                        </a>

                        <div class="card-body">
                            <button onclick="window.location.href ='{{route('home')}}?sort=result'">Sort By Votes!</button>
                            <button onclick="window.location.href ='{{route('home')}}'">Sort By Date!</button>
                            <div class="card-deck">
                                @forelse($questions as $question)
                                    <div class="col-sm-4 d-flex align-items-stretch">
                                        <div class="card mb-3 ">
                                            <div class="card-header" style="background-color: #1d2124; color: #e2e6ea">
                                                <small style="color: #fefefe">
                                                    Updated: {{ $question->created_at->diffForHumans() }}
                                                    Answers: {{ $question->answers()->count() }}<br>
                                                    @if (\App\Profile::find ($question->user_id))
                                                        Created By: {{ \App\Profile::find ($question->user_id)->fname }}
                                                    @else
                                                        Created By: {{ \App\User::find($question->user_id)->email }}
                                                    @endif
                                                </small>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text">{{$question->body}}</p>
                                            </div>
                                            <div class="card-footer">
                                                <p class="card-text">
                                                @if (Auth::user())
                                                    @if(Auth::user() != $question->user)
                                                        <div class="votes-area" data-postid="{{ $question->id }}" data-userid="{{ Auth::user()->id }}">


                                                            <img  class="voter" data-votetype="up" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRw9lFyg_qYEks4q-6c_Yr4oBG1lPtFtodNGCSeOgf6nJdjL50KSQ" width="30" height="30">
                                                            <span >{{ $question->votes_up }}</span><br>

{{--                                                            <a class="btn btn-primary float-right" style="background-color: mediumblue" href="{{ route('question.vote', ['id' => $question->id]) }}">--}}
{{--                                                                {{ $question->votes_up }}--}}
{{--                                                            </a>--}}
                                                            <span id="resultVote">{{ $question->result }}</span><br>
                                                            <img class="voter" data-votetype="down" src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxATEBUTEw8VEBQXFxUXFRUXFQ8dGhcaHRUXFhUYHxUYHSggGBslGxYVITIhJSkrLjMuFx8zODMuNygtLisBCgoKDg0OFRAPFSsZFRkrKystKy0tLS0tKysrKzErKysrKysvKysrKysrLS0rKysrKysrKys3LSsrKysrKysrK//AABEIAOEA4QMBIgACEQEDEQH/xAAcAAEAAgMBAQEAAAAAAAAAAAAAAQcFBggCBAP/xABWEAABAgQCBwIGCwsKBAcAAAABAAIDITFhBBEFBgcSQXGxE1EUInSBkbMIJEJSYnKSk6HD0RcjJTJTVFWClNLTFTM0NUODwcLw8UVzouEWRGNkZaOy/8QAFQEBAQAAAAAAAAAAAAAAAAAAAAH/xAAWEQEBAQAAAAAAAAAAAAAAAAAAARH/2gAMAwEAAhEDEQA/ALvTPuQ9yiwQSTwCE8OKikhVa7r3rXD0bhDFI34rjuwYfv35Z5nuaBMnzVIQfZrJrPhMDD38TGDM891gm9+Vd1gmeE6DiVVWmtt0Y5jC4RkJvB8clzvm2EBvyitf1Z1Xx2msS/Ex4zmw97KJHIzzNeyhMpIH4rc+Jkbn1f1D0bg2js8K17x/axAHxCfjOHi8mgCyKpk7SNPR/wCajO/ucNDd/kcV5GmdZ4lDpE3GGitHpbDAC6MaMh3W7kHeUHOxw+tD/wBI/LjN/wAwXk6I1n/+S/aY38VdF15JXl1Q1zsNHa0N/SPz8Y/5yoOI1oZ+kjyhx39GldFV5JYIa5zGs2srKvxw+NhCf/1BXsbT9Nw5PjfOYeGP8oXRNgju6qDn/C7atJD8ZuFif3cUH6Iiy2G25Rx+Po6G67Y72/QYbuqt/EaLw75Pw8KIfhQ4Z6hYnE6i6JfN2jsOSeLYbGk+duSDTcLtvwh/nMFiGXaYDh9Lmn6FmsHtb0Q/8aNEhH4cGN1aCPpU4vZNod0+wfCJ95Gj/Q1ziPoWFxWxHB5Ew8biIdniA8D0MaT6UG6YLXbRcWTdI4ck0aYrGn5LyDms7BjNcN5rg4d4II9IVJYzYhiQCYeOhP7g+HEZ9ILuiwUXZbprD+NCgtceJw8djT/1FhQdGA+ZfDpjTOHwsIxsRFbBhCW8c5k0AAm4nuE1z+dJayYT8Z2OYBxex8Vvy3Nc36VhdZ9bcZjuzGJiB/Zb26A0Nmcsy5olvZACglzQxdZ2waI/KRvmIv2KDtg0R+UjfMRfsWB0NsdwMbDwYpxWKaYkKG9wBw2QLmBxAzhZ8V9h2I4DP+l4v5WF/hIMkdsGiPykb5iL9in7sGiPykb5iL9ixh2JYD87xfysL/CR2xLAfneLz+Nhf4SDM4PaxoiI8M8IdDJkHRIUVrBzeRk0XMlu4cMhPPOl1z7tO1Aw2jYEGJCjxopiRCwiIYOQG452Y3GNnmArP2PYp79D4cvcXFvaw2k13WRntY3zNAHmQbopUKUR5J4BRSQqpJ7qqKXKBS5XPm1zHRMXpjwZp/mzCw8MGnaRNxznecvY39RdB0uVzq4jEaz+LMHHj/6nzPohEosX7oTRcLC4eHAhjJkNoaO895PeScyT3kr7blLlLlELlK8krySvLqgV5dUrySvJLBAsEsP9ksEpIIFJBKXKUuUpcoFLlKTNUpM1S5QLlLlLlKzNECszRK8uqV5dUryQK8lRO34Dw6DkP/L/AFj1e1ZBUVt/y8OgeT/WPRYuLVg+0cKB+Qg+rasnSQWM1YPtHCgfkIPq2rJ0uUQpcpS5SlylJmqCq/ZBD2phfKD6l6zmxX+poJ+HiPXxFg/ZBA+CYXyg+pes5sVH4Gg/HxHr4iK3pSozUojyTlzUUuVJOS0navrQ/A4L707dxEcmHDd7wZZveLgSF3BBiNpW0tuFLsLhCImJyIiRKtgWHvolqDj3LB7D9VYhinSEZpDA1zYG9nm9zpPiznllm0HjvO7p/Hsm1AZih4bihvQA53ZwzPtnAkOe7OrA7MZe6IOcq3mxoAEsgKDgAipHeUrySvJK8uqIV5dUrySvJLBAsEsP9ksEpIIFJBKXKUuUpcoFLlKTNUpM1S5QLlLlLlKzNECszRK8uqV5dUryQK8ksEsEsECwVFbfx7egeT/WPV60kFRO38e3oHk/1j0WLj1YlgcLlXsIPq2rJ0uVjdWJYHC8T2EH1bVkqTNUQpM1S5S5S5QVX7ILPwTC+UH1L1nNio/A0H4+I9fEWD9kEfamF8oPqXrObFR+BoPx8R6+Iit7zRERHkymqk9kDo97oWFxGRLWPiw3W7QMc0n5ojzhW2e8rGayaGZjMJFw8STYjSAfeuqx/MOAPmQa1sc0syPouEwZB+HzhPbyObHedpaeea3evJc+bIdIxMJpfwWJ4oi78CK3gIkPecw+Yte39ddB15dUCvLqleSV5JYIFglglglJBApIJS5SlylLlApcpSZqlJmqXKBcpcpcpWZogVmaJXl1SvLqleSBXklZBKyCWCBYJSQSkglLlApcqidv49vQPJ/rHq9qXKonb+Pb0Dyf6x6LFyarywOGP/oQfVtWSuVjNV/6DhifyEH1bVk7lELlKzNErM0SvLqgqv2QR9qYXyg+pes5sV/qaD8fEeviLB+yCPtTC+UH1L1nNiv9TQfj4j18RFb2ijJSiPJHErE6y6wYfBQHR8Q/daJNYMt6I7g1reJPoFTkAssQucdZ8XiNMaZ7GG6XaOgwAc92GxhO/EyuGOeeJyaOAQfvqBCi6Q08MTuboEV+Ji5Z5MHjbjc+JLi0XyceBXQ1eSwmqOq+HwGHEGCM85xIhy3oruJJ7uAFAFm7BAsEsEsP9kpIIFJBKXKUuUpcoFLlKTNUpM1S5QLlLlLlKzNECszRK8uqV5dUryQK8krIJYJYIFglJBKSCUuUClylLlKXKUmaoFJmqonb/n4dA8n+ser2uVRO3/Pw6B5P9Y9Fi49Vx7RwpP5CD6tqydZmixmq49o4XP8AIQfVtWTry6ohXl1SvLqleXVKyFEFV+yCPtTC+UH1L1nNip/A0H4+I9fEWD9kFl4JhfKD6l6zmxU/gaD8fEeviIreslKhSiPJGfJc5ap4kYDWDdjeK0R40F5PAPLmw3Z8ASYZz7iSujTPkqi21alGJnpCA3eLWZYlg4taJRR3lrZO+CAeBzC3D3BLBVfsW1xiYhjsFHdvRITd6E81dCBDSCeLmktGfEOHEEm0KSCBSQSlylLlKXKBS5SkzVKTNUuUC5S5S5SszRArM0SvLqleXVK8kCvJKyCVkEsECwSkglJBKXKBS5SlylLlKTNUCkzVLlLlLlAuVRO38+3oHk/1j1e1Zmionb+fb0Dyf6x6LFx6rjPA4Xu7CD5/vbVk68uqxmrE8Dhe7sIPq2rJ1kKIhWQolglglggqv2QWXgmFH/uD6l6zmxU/gaD8fEeviLB+yCHtTC+UH1L1nNip/A0H4+I9fERW9ooUojye5Urtp1yc6IdHQHEMbl4QW55vcZtgjKZAzBIFSQOBBtvWDSXg2Fjx8t7soUSJl37rC4Dz5ZKitj2iPDNJujxj2hggx3Z+6iucdxxFnb7+bWore9lez52CyxWIJ8JewtEIZbsFriCQT7p/ijPgJgZ1NkUuUpcpS5RClylJmqUmapcoFylylylZmiBWZoleXVK8uqV5IFeSGcglZBLBAsEpIJSQSlygUuUpcpS5SkzVApM1S5S5Xz4/Gw4MJ8aM8Q4cNpc4mgA6myCcdjYUGG6NGiNhQ2jMucQABzPFVRrHtqaHFuCw3aAUixt4NPcRCGTiOZabLT9P6bx2nMc2FCYdzM9jBzybDaJGLEIlnkZunlnujPPxrU1R2XYDCta6LDbjI0iXxGgtB+BCMmgd5zN0VWB2r6ZiTbFh5cQyAwt+neP0rXNZtZ8Tj4jYmIcxz2M7Mbjd2WZMxmZ5k9y6qYwZZNAa0cAAPNyWva5amYXSMMMiN7N7TmyMwN3mniPhNPEH6CAUGN1f170UzB4djsfBY5sGE1zS7IgiG0EZd4KyB2gaIoNIwB+sq/Owx+ctKN/ZT/HUHYY/P+tG/sp/joLB+6BojKWkYHy0+6BogCWkYHy1Xzthj/0o39lP8dHbDH/pRv7Kf46D89tGseCxWGw7cNiocdzYxc4MdmQOyeM+WZAW57F25aGgEir8Rl+0RFrGD2HNa8GNpExGcWQ4G451t8xHZehWxgMFDgwmQ4bBDYxoaxoo1oGQH/dB9ClQpRGO1iwPb4TEQBWLBiw+W8xzQfpVG7DNJ9lpJ0J3i9vCc0Ay8dhDw3Lv3RE9C6BJ9K562oaAi6O0kMVBzZDixO2hPAkyKDvvYf1s3AcQ4jgUV0JS5SkzVaxqHrpA0hA3gQzENA7aDnNp9833zDwPmM1s9yiFylylylZmiBWZoleXVK8uqV5IFeSWCVkEsECwSkglJBKXKBS5SlylLlKTNUCkzVLlLlLlAuVSu3bWguiNwDHZNYGxY86uIzhsPIZPy+Ew8FcGlceyBAiR4pyhwmOe7k0E+cykFz5qFgImlNM9rGG8N92Kj90nAsh5928WNy9609yKtfZTqiMFgw+IzLERgHxcxNoqyFyaDP4RNlu1eXVK8uqVkKIhWQolglglggWCUkKpSQqlLlApcpSZqlJmqXKBcqQOJUXKkTmgnNSozUoPJOXNfBprREDFQHwcQwRGPGRHEHgWmrXAzBC+8ymouUHPes2zvSOjooj4UxI0NpzZFhZ9rDs5jZm5aCDPMCi/fRe2XSENu7FhQcURLfO8x0q7274pPIBX7crG43V7BR3b8bBYeK73z4MFx9LhmiqiO2/FfmMH5yL9iO234r8xg/ORfsVqDU/RZ/4ZhAPJsPP/AKU/8H6LP/DMJl5Nh/3UFVnbfivzGD85F+xPu34r8xg/ORfsVqHU/RZpozCc/BsP+6h1P0XQaMwnPwbD/uoKr+7fisv6DBH95F+xBtvxX5jB+ci/YrUOp+i6fyZhM/J8P+6h1P0WJfyZhCfJ8P8AuoNE1P2vHEYuHh4+FZBEVwYyIx7jk8yYHBwo45DMGpEpytalyubdOQYZ1h7PDQmQ2NxmHhsZDa1rQWvhNed1oyHjh5K6TpPiiIpM1S5S5S5QLlKzNErM0QnOZkP9fQgqzbxp/cw0PBtM4zt+J/y2EFvpfl8gr79iOgOxwBxDm5PxLt/hn2bc2whyPjP/AFwqw0zHdpjTe6wktixRChEe5gszzcP1REifrLo/DwWsY2GwbrGNDQBwAGQA8wRX6VkKJYJYJYIhYJSQqlJCqUuUClylJmqUmapcoFylylylZmiBWZopE+SivLqpzz5dUHpERB5PeVFypI4lRWZogVmaJXl1SvLqleSBXklZBLBLBAsEpIJSQSlygUuVh9btPMwODi4h8y0ZMb795kxvLOvcASsxS5VB7adYXYnGtwkPN7IB3SGz347sgQBxLQQwXc8IPGxfRD8RpI4qJm9sAOiOcfdRom8G2JnEdbIK/wC5Wv6h6tt0fgYcGXafjxnD3URwG9zAyDRZoWwXKBcpWZolZmiV5dUCvLqtF2wayjC6PdDY7KLiM4TMjMNy++vHdk05Z972raNYdPYbCQTGxEQQ2Cg9088GNbVxP+pLn3Fx8Xp3SgDW7m94rG1bAggzce/LPM97iB3INx2C6u/zuOe3ITgwfSDFcPOGtzs5XHYL5NEaOh4aBDw8EbrIbQ0eapJ4uJzJPeSvrsECwSkhVKSFUpcoFLlKTNUpM1S5QLlLlLlKzNECszRK8uqV5dUry6oFeXVTn3UUVkKKc+AQeskUZKUHkhRXl1UkZ8lFeSBXklZBKyCWCBYJSQSkglLlApcpS5SlylJmqDDa4abbgsDGxJyLmtyYD7p7vFht5bxGds1TOxjQRxWkHYqLm9uH++Fx93HeSWm5HjvN93vWW2/abziQMGHSYDHii5zZCHmHaHzhb9sw0D4Ho2C1zd2JEHbRc8s954ByN2t3W/qora7lKzNErM0SvLqiFeXVantA14g6OhCQix3g9lCzyz4b7j7lgPnNBxIzmsGl4WFw0XERTlDhtLj3uNGtF3OIaLkKgNW9E4nTmk3xIziG5h8d4/s2ZkQ4TM6ULW2DicznmHjRuitKacxRiOeXgSdGfmIUEE57jGjjTxWzoXHirz1O1Sw2j4PZwQXPdkYsZ2W88inICeTRIZ95JOX0dgIUCE2DAhiFDYMmtbQD/E3M19FggWCUkKpSQqlLlApcpSZqlJmqXKBcpcpcpWZogVmaJXl1SvLqleXVAry6pWQolZCiWCBYKbBRYKaSQSpUKUHkjPkorIKT3KLBAsEpIJSQSlygUuUpcpS5SkzVApM1UgcSouV+GOeWwoj+LWOIFw0kIOd3j+U9YSHeMyJiSCKjsYXDkYcL0uXR4GczRc9bCGB2lQXHMtw0VwPwt6E0n0Ocuha8uqLSvLqleXVK8uqVkKIin9v2nMhAwbXSOceKM+AzbCBtnvnmwLcNlWgfBNGwgW5RYwEaKSJguALGn4rN0Zd4KqXW5vh+sToWe8w4iFhwO5jN1sUekRT510UBlID/ALIpYJSQqlJCqUuUQpcpSZqlJmqXKBcpcpcpWZogVmaJXl1SvLqleXVAry6pWQolZCiWCBYJYJYJSQqgUkKqRLmopcqRLmglSoUoPJPAKKSCkngFFLlApcpS5SlylJmqBSZqlylylygXKhzd4HOncprM0SvLqg502YO8F06yEZePiMMfMHAD5UNq6Lry6rnnajhH4HTRxEMSe6HiYfAFzSO0bnd7ST/zFfujcczEQYcaEc4cRjXtNnAEeeaK+mshRHOy5CqWC+DWDECHhMQ/3kGK7llDcf8ABEULspb4Rp1kas8TiJ/Ca4dYoK6JpIVVC7AcP+EIr/eYYtH60WF+4VfVLlFpS5SkzVKTNUuUQuUuUuUrM0QKzNEry6pXl1SvLqgV5dUrIUSshRLBAsEsEsEpIVQKSFUpcpS5SlygUuVIHEqKTKkDiUEqURB5J9KilyvRUAZT4oIpM1S5UgcSgHEoIuUrM0U5Z1TLPl1QRXl1SvLqpM+SHuQaTtX1VOOwecJu9HgEvhgZZvGWUSF5wARdrVoux/XxkAeA4p/Zwy4mBEdIQ3E+NDcT+KCZgmhJB4K8D3BVhtF2WDEvdiMHuw47pxITpMini4H3Dz6DxyOZQWdnwCwG0B+7onHeS4gemE4f4qj8HprT+jPvftiExv8AZxYfaQ+TXEEAfEcAvoxmuWndIQnYYQi9kQFrxBwzvGaatLzvBoPfLmi4zXsfR7ZxZ7oUEel7/sV20maqvdkOpcfAQ4sXEZNixhDAhAg7jW7xG84S3iXmQJAyE1YYHEoiLlLlSBxKZZ1QRWZoleXVTlnyQz5dUEV5dUrIUUnu4Ie4IIsEsFNglKIIpIVSlypyyuUAyuUEUuUpMqQOJQDiUEXKkTmUyzmUryQTmpREEIpRBCFSiAUREBQFKIICKUQFAREBFKIIKFSiAiIgBQFKIIRSiCEUoghSiIIKlEQQiIg//9k=" width="30" height="30">
                                                            <span >{{ $question->votes_down }}</span>
{{--                                                            <span class="voter" data-votetype="down">{{ $question->votes_down }}</span>--}}
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="votes-area">
{{--                                                        <span onclick="alert('Only registered users can vote');">{{ $question->votes_up }}</span>--}}
{{--                                                        <span onclick="alert('Only registered users can vote');">{{ $question->result }}</span>--}}
{{--                                                        <span onclick="alert('Only registered users can vote');">{{ $question->votes_down }}</span>--}}
                                                    </div>
                                                @endif

                                                    <a class="btn btn-primary float-right" style="background-color: mediumblue" href="{{ route('question.show', ['id' => $question->id]) }}">
                                                        View
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <a class="btn btn-primary" style="background-color: mediumblue" href="{{ route('question.create') }}">
                                    There are no questions to view, you can  create a question.
                                    </a>
                                @endforelse


                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="float-right">
                                {{ $questions->links() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
        <script type="text/javascript">
            window.onload = function() {
                var token = "{{ Session::token() }}";
                var url = "{{ route('question.vote') }}";
                var voteSpans = document.getElementsByClassName("voter");
                //var voteSpans = document.querySelectorAll("voter");

               // console.log(voteSpans.length);
                for (var i = 0; i < voteSpans.length; i++) {
                    //   console.log("on click");
                    voteSpans[i].addEventListener('click', vote, true);
                    //voteSpans[i].addEventListener('click', vote, false);
                    //voteSpans[i].onclick =  vote;
                    // console.log(voteSpans[i]);
                }

                function vote() {
                    console.log("something");
                    var voteType = this.dataset.votetype;
                    var parentDiv = this.parentNode;
                    var postId = parentDiv.dataset.postid;
                    var userId = parentDiv.dataset.userid;
                    var spanClicked = this;


                    var xhr = new XMLHttpRequest();

                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            var obj = JSON.parse(xhr.responseText);
                            console.log(obj);
                            if ("warning" in obj) {
                                var pWarning = document.createElement("p");
                                pWarning.textContent = obj.warning;
                                spanClicked.parentNode.appendChild(pWarning);
                                setTimeout(function functionName() {
                                    spanClicked.parentNode.removeChild(pWarning);
                                }, 3000);
                            }
                            else {
                                if (spanClicked.dataset.votetype == "up") {
                                    spanClicked.nextElementSibling.textContent = obj.up;
                                    console.log(spanClicked.nextElementSibling.nextElementSibling);
                                    spanClicked.nextElementSibling.nextElementSibling.nextElementSibling.textContent = obj.result;
                                    spanClicked.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.textContent = obj.down;
                                }
                                else {
                                    spanClicked.nextElementSibling.textContent = obj.down;
                                    spanClicked.previousElementSibling.previousElementSibling.textContent = obj.result;
                                    spanClicked.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.textContent = obj.up;
                                }
                            }
                        }
                    }

                    xhr.open('POST', url, true);
                    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");
                    xhr.send("postId=" + postId + "&userId=" + userId + "&voteType=" + voteType + "&_token=" + token);
                }

            };


        </script>
@endsection