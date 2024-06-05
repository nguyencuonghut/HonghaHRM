
<!-- Offer chế độ -->
<div class="tab-pane fade" id="custom-tabs-one-profile-8" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab-8">
    <h2>{{$proposal->company_job->name}}</h2>

          <!-- Default box -->
    <div class="card card-solid">
        <div class="card-body pb-0">
            <div class="row">
                @foreach ($proposal->candidates as $candidate)
                @php
                $proposal_candidate = App\Models\ProposalCandidate::where('proposal_id', $proposal->id)->where('candidate_id', $candidate->id)->first();
                $offer = App\Models\Offer::where('proposal_candidate_id', $proposal_candidate->id)->first();
                @endphp
                @if($offer && $offer->result)
                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column mb-4">
                        <div class="position-relative p-3 bg-gray" style="height: 170px">
                            <div class="ribbon-wrapper ribbon-lg">
                                <div class="ribbon
                                    @if ('Không đạt' == $offer->result)
                                        bg-danger
                                    @elseif ('Ký HĐLĐ' == $offer->result)
                                        bg-success
                                    @elseif ('Ký HĐTV' == $offer->result)
                                        bg-primary
                                    @else
                                        bg-warning
                                    @endif
                                    text-lg"
                                >
                                    {{$offer->result}}
                                </div>
                            </div>
                            {{$candidate->name}}
                            <br>
                            <i class="fas fa-calendar-alt"><small> {{date('d/m/Y', strtotime($candidate->date_of_birth))}}</small></i>
                            <br>
                            <i class="fas fa-map-marker-alt"><small> {{$candidate->commune->name}}, {{$candidate->commune->district->name}}, {{$candidate->commune->district->province->name}}</small></i>
                            <br>
                            <i class="fas fa-mobile-alt"><small> {{$candidate->phone}}</small></i>
                            <br>
                            <i class="fas fa-graduation-cap">
                              <small>
                                @php
                                    $educations_info = '';

                                    foreach ($candidate->educations as $education) {
                                        $candidate_education = App\Models\CandidateEducation::where('candidate_id', $candidate->id)->where('education_id', $education->id)->first();
                                        if ($candidate_education->major) {
                                            $educations_info = $educations_info . $education->name . ' - ' . $candidate_education->major . '<br>';
                                        } else {
                                            $educations_info = $educations_info . $education->name;
                                        }
                                    }
                                @endphp
                                {!! $educations_info !!}
                              </small>
                            </i>
                            <br>
                            <i class="fas fa-hand-holding-usd"><small> {{number_format($offer->position_salary + $offer->capacity_salary + $offer->position_allowance, 0, '.', ',')}}<sup>đ</sup></small></i>
                        </div>
                    </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
