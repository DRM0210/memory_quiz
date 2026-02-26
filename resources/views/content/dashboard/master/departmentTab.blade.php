<div class="row">

  <div
      class="col-md-2 @if (count($deptData) == 0) hide @endif">
      {{-- <form
          action="{{ route('client-view', ['id' => $client->id]) }}"
          method="GET">
          <div
              class="input-group input-group-merge">
              <input
                  type="text"
                  class="form-control"
                  name="machine"
                  placeholder="Search..."
                  aria-label="Search..."
                  aria-describedby="basic-addon-search31">
              <button
                  class="input-group-text"
                  type="submit"
                  id="searchButton">
                  <i
                      class="bx bx-search"></i>
              </button>
          </div>
      </form> --}}
  </div>
  <div
      class="@if (count($deptData) == 0) col-md-12 @else col-md-10 @endif textRight">
      <span class="w-100"><a
              href="{{ route('machine-create', ['id' => $client->id, 'did' => $item->id, 'mtid' => $t1->id]) }}"
              class="btn btn-md btn-info">Add
              Machine</a></span>
  </div>
</div>

@if (count($deptData) != 0)
  <div
      class="table-responsive text-nowrap">
      <table class="table">
          <thead>
              <tr>
                  <th>Product</th>
                  <th>Machine Make/ Model</th>
                  <th>PF Size</th>
                  <th>Capacity (min / max)</th>
                  <th>Serial</th>
                  <th>Sales Date</th>
                  <th>Warrenty</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody
              class="table-border-bottom-0"
              id="deptMachineData">
              @php
                  //dd($deptData);
              @endphp
              @if (count($deptData) != 0)
                  @foreach ($deptData as $d)
                      <tr>
                          <td><a class="text-info"
                                  title="View"
                                  data-bs-toggle="modal"
                                  data-bs-target="#basicModal{{ $d->id }}"
                                  href="javascripti:void()">{{ $d->name }}</a>
                          </td>
                          <td>{{ $d->make_model }}
                          </td>
                          <td>{{ $d->platform_size }}
                          </td>
                          <td>
                            @if(!empty($d->platform_min_capacity) && !empty($d->platform_max_capacity))
                            {{ $d->platform_min_capacity }} / {{ $d->platform_max_capacity }}
                            @endif
                          </td>
                          <td>{{ $d->serial }}
                          </td>
                          <td>{{ \Carbon\Carbon::parse($d->purchase_date)->format('d-m-Y') }}
                          </td>
                          <td>{{ $d->warrenty_status }}
                          </td>

                          <td>
                              @if (count($job) > 0)
                                  <a class="box-edit bg-warning"
                                      href="{{ route('client.job', $d->client_id) }}">Job
                                      ({{ count($job) }})
                                  </a>
                              @else
                                  <a class="box-edit border-warning text-warning"
                                      href="{{ route('client.job.create', $d->client_id) }}?machine_id={{ $d->id }}">Job
                                  </a>
                              @endif
                              <a class="box-view mx-1"
                                  title="View"
                                  data-bs-toggle="modal"
                                  data-bs-target="#basicModal{{ $d->id }}"
                                  href="javascript:void(0)">
                                  <i class="bx bx-show"
                                      style="font-size: 20px;"></i>
                              </a>


                              <a class="box-edit"
                                  href="{{ route('machine-edit', ['id' => $d->client_id, 'id1' => $d->id]) }}"><i
                                      class="bx bx-edit-alt"></i></a>
                              <a class="deleteClient box-delete"
                                  data-id="{{ $d->id }}"
                                  href="javascript:void(0)"><i
                                      class="bx bx-trash"></i></a>

                          </td>
                      </tr>
                      <script>
                          $(".deleteClient").click(function() {
                              let id = $(this).attr('data-id');
                              let _token = $('input[name="_token"]').val();

                              Swal.fire({
                                  title: 'Are you sure?',
                                  text: "Do you want to delete this item?",
                                  icon: 'warning',
                                  showCancelButton: true,
                                  confirmButtonColor: '#d33',
                                  cancelButtonColor: '#3085d6',
                                  confirmButtonText: 'Yes, delete it!',
                                  cancelButtonText: 'Cancel'
                              }).then((result) => {
                                  if (result.isConfirmed) {
                                      $.ajax({
                                          type: 'POST',
                                          url: "{{ route('machine-delete') }}",
                                          data: {
                                              id: id,
                                              _token: _token
                                          },
                                          success: function(data) {
                                              if ($.isEmptyObject(data.error)) {
                                                  Swal.fire(
                                                      'Deleted!',
                                                      'Your item has been deleted.',
                                                      'success'
                                                  ).then(() => {
                                                      location.reload();
                                                  });
                                              } else {
                                                  printErrorMsg(data.error);
                                              }
                                          }
                                      });
                                  }
                              });
                          });
                      </script>
                      <style>
                          .client-view-list{
                          position: relative;
                          }

                          .client-view-list .heading{
                          font-size: 14px;
                          font-weight: 500;
                          color: #000
                          }

                          .client-view-list .heading::after {
                              position: relative;
                              top: 3px;
                              content: "\eb8b";
                              font-family: "boxicons" !important;
                              font-size: 14px;
                              color: #222;
                              font-weight: 600;
                          }

                          .client-view-list .sub-heading{
                          font-size: 14px;
                          }

                          .section-heading {
                              width: 100%;
                              font-size: 14px;
                              font-weight: bold;
                              color: #0063a6;
                              border-bottom: 2px solid #0063a6;
                              margin-top: 20px;
                              margin-bottom: 10px;
                              padding-bottom: 5px;
                              position: relative;
                          }

                      </style>

                      <!-- Modal -->
                      <div class="modal fade"
                          id="basicModal{{ $d->id }}"
                          tabindex="-1"
                          aria-hidden="true">
                          <div class="modal-dialog modal-lg"
                              role="document">
                              <div
                                  class="modal-content">
                                  <div
                                      class="modal-header">
                                      <h5 class="modal-title"
                                          id="exampleModalLabel1">
                                          {{ $d->name }}
                                      </h5>
                                      <button
                                          type="button"
                                          class="btn-close"
                                          data-bs-dismiss="modal"
                                          aria-label="Close"></button>
                                  </div>
                                  <div
                                      class="modal-body pt-0">

                                              <div
                                                  class="machine-table">
                                                  <div class="well well-xs customer-snapshot">
                                                      <div class="list-group">
                                                          <div class="row">
                                                              <div class="section-heading">Client Deatils</div>
                                                              <div class="col-lg-6">
                                                          @php
                                                              $Mclient = \App\Models\Client::where('id', $d->client_id)->first();
                                                              $MDepartment = \App\Models\PlantDepartment::where('id', $d->department_id)->first();
                                                              $Mmachine = \App\Models\MachineType::where('id', $d->machine_type)->first();
                                                          @endphp
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Client</span>
                                                              <span
                                                                  class="sub-heading">{{ $Mclient->name }}</span>
                                                          </div>
                                                      </div>
                                                      <div class="col-lg-6">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Department
                                                                  ID</span>
                                                              <span
                                                                  class="sub-heading">{{ $MDepartment->name }}</span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-6">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Machine
                                                                  Type</span>
                                                              <span
                                                                  class="sub-heading">{{ $Mmachine->name }}</span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-6">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Product Name</span>
                                                              <span
                                                                  class="sub-heading">{{ $d->name }}</span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-6">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Product Category</span>
                                                              <span
                                                                  class="sub-heading">{{ $d->add_type }}</span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-6">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Product Type</span>
                                                              <span
                                                                  class="sub-heading">{{ $d->type }}</span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-6">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Make/ Model</span>
                                                              <span
                                                                  class="sub-heading">{{ $d->make_model }}</span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-6">
                                                              <div
                                                                  class="client-view-list">
                                                                  <span
                                                                      class="heading">Serial</span>
                                                                  <span
                                                                      class="sub-heading">{{ $d->serial }}</span>
                                                              </div>
                                                              </div>
                                                          <div class="section-heading">Offer
                                                              Details</div>

                                                          @php
                                                              $offerDetails = json_decode($d->offer_details, true) ?? [];
                                                              $offerDetailsFiles = json_decode($d->offer_details_file, true) ?? [];
                                                          @endphp
                                                           <div class="col-lg-4">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Offer Number</span>
                                                              <span
                                                                  class="sub-heading">

                                                                  {{ $offerDetails[0] }}
                                                                </span>
                                                          </div>
                                                      </div>
                                                      <div class="col-lg-4">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Offer Date</span>
                                                              <span
                                                                  class="sub-heading">
                                                                  {{ $offerDetails[1] }}
                                                                </span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-4">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Offer
                                                                  Details
                                                                  File</span>
                                                              <span
                                                                  class="sub-heading">
                                                                  @if (!empty($offerDetailsFiles) && is_array($offerDetailsFiles))
                                                                      @foreach ($offerDetailsFiles as $offerDetailsFile)
                                                                          <a href="{{ asset($offerDetailsFile) }}" target="_blank" rel="noopener noreferrer">View</a>
                                                                      @endforeach
                                                                  @endif

                                                            </span>
                                                          </div>
                                                          </div>
                                                          <div class="section-heading">PO
                                                              Details</div>

                                                          @php
                                                            $poDetails = json_decode($d->po_details, true) ?? [];
                                                            $poDetailsFiles = json_decode($d->po_details_file, true) ?? [];
                                                        @endphp
                                                        <div class="col-lg-4">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">PO Number</span>
                                                              <span
                                                                  class="sub-heading">

                                                                   {{ $poDetails[0] }}
                                                                </span>
                                                          </div>
                                                      </div>
                                                          <div class="col-lg-4">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">PO Date</span>
                                                              <span
                                                                  class="sub-heading">

                                                                   {{ $poDetails[1] }}
                                                                </span>
                                                          </div>
                                                      </div>
                                                          <div class="col-lg-4">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">PO
                                                                  Details
                                                                  File</span>
                                                              <span
                                                                  class="sub-heading">
                                                                  @if (!empty($poDetailsFiles) && is_array($poDetailsFiles))
                                                                      @foreach ($poDetailsFiles as $poDetailsFile)
                                                                          <a href="{{ asset($poDetailsFile) }}" target="_blank" rel="noopener noreferrer">View</a>
                                                                      @endforeach
                                                                  @endif

                                                            </span>
                                                          </div>
                                                          </div>
                                                          <div class="section-heading">Invoice
                                                              Details</div>
                                                          @php
                                                              $invoiceDetails = json_decode($d->invoice, true) ?? [];
                                                              $invoiceFiles = json_decode($d->invoice_file, true) ?? [];
                                                          @endphp
                                                           <div class="col-lg-4">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Invoice Number</span>
                                                              <span
                                                                  class="sub-heading">

                                                                  {{ $invoiceDetails[0] }}
                                                                </span>
                                                          </div>
                                                      </div>
                                                          <div class="col-lg-4">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Invoice Date</span>
                                                              <span
                                                                  class="sub-heading">

                                                                  {{ $invoiceDetails[1] }}
                                                                </span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-4">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Invoice
                                                                  Details
                                                                  File</span>
                                                              <span
                                                                  class="sub-heading">
                                                                  @if (!empty($invoiceFiles) && is_array($invoiceFiles))
                                                                      @foreach ($invoiceFiles as $invoiceFile)
                                                                          <a href="{{ asset($invoiceFile) }}" target="_blank" rel="noopener noreferrer">View</a>
                                                                      @endforeach
                                                                  @endif

                                                            </span>
                                                          </div>
                                                          </div>
                                                          <div class="section-heading">Platform</div>
                                                          <div class="col-lg-3">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">
                                                                  Size</span>
                                                              <span
                                                                  class="sub-heading">{{ $d->platform_size }}</span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-3">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">
                                                                  Max
                                                                  Capacity</span>
                                                              <span
                                                                  class="sub-heading">{{ $d->platform_max_capacity }}</span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-3">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">
                                                                  Min
                                                                  Capacity</span>
                                                              <span
                                                                  class="sub-heading">{{ $d->platform_min_capacity }}</span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-3">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">
                                                                  Least
                                                                  Count</span>
                                                              <span
                                                                  class="sub-heading">{{ $d->platform_least_count }}</span>
                                                          </div>
                                                          </div>
                                                          <div class="section-heading">LoadCell</div>
                                                          <div class="col-lg-3">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">
                                                                  Modal</span>
                                                              <span
                                                                  class="sub-heading">{{ $d->loadcell_modal }}</span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-3">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">
                                                                  Type</span>
                                                              <span
                                                                  class="sub-heading">{{ $d->loadcell_type }}</span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-3">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">
                                                                  Capacity</span>
                                                              <span
                                                                  class="sub-heading">{{ $d->loadcell_capacity }}</span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-3">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">
                                                                  Serial
                                                                  No</span>
                                                              <span
                                                                  class="sub-heading">{{ $d->loadcell_serial_no }}</span>
                                                          </div>
                                                          </div>
                                                          <div class="section-heading">System</div>
                                                          <div class="col-lg-3">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Modal</span>
                                                              <span
                                                                  class="sub-heading">{{ $d->system_modal }}</span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-3">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Type</span>
                                                              <span
                                                                  class="sub-heading">{{ $d->system_type }}</span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-3">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Cables</span>
                                                              <span
                                                                  class="sub-heading">{{ $d->system_cables }}</span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-3">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Least
                                                                  Count</span>
                                                              <span
                                                                  class="sub-heading">{{ $d->system_least_count }}</span>
                                                          </div>
                                                          </div>
                                                          <div class="section-heading">JB</div>
                                                          <div class="col-lg-6">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Modal</span>
                                                              <span
                                                                  class="sub-heading">{{ $d->jb_modal }}</span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-6">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Ports</span>
                                                              <span
                                                                  class="sub-heading">{{ $d->jb_ports }}</span>
                                                          </div>
                                                          </div>

                                                          @php
                                                          $inclusion = json_decode($d->inclusion, true) ?? [];
                                                          $exclusion = json_decode($d->exclusion, true) ?? [];
                                                          $additionalData = json_decode($d->additional, true) ?? [];
                                                          $inclusionData = json_decode($d->inclusionAdditional, true) ?? [];
                                                          $exclusionData = json_decode($d->exclusionAdditional, true) ?? [];
                                                      @endphp
                                                      <div class="section-heading">Inclusion</div>
                                                      <div class="col-lg-3">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Label</span>
                                                              <span
                                                                  class="sub-heading">
                                                                   {{ $inclusion['label'] ?? '' }}

                                                                </span>
                                                          </div>
                                                      </div>
                                                          <div class="col-lg-3">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Start Date</span>
                                                              <span
                                                                  class="sub-heading">
                                                                  {{ $inclusion['start_date'] ?? '' }}

                                                                </span>
                                                          </div>
                                                      </div>
                                                          <div class="col-lg-3">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">End Date</span>
                                                              <span
                                                                  class="sub-heading">

                                                                  {{ $inclusion['end_date'] ?? '' }}

                                                                </span>
                                                          </div>
                                                      </div>
                                                          <div class="col-lg-3">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">File</span>
                                                              <span
                                                                  class="sub-heading">
                                                                  @if (!empty($inclusion['pdf']) && is_array(json_decode($inclusion['pdf'], true)))
                                                                      @foreach (json_decode($inclusion['pdf'], true) as $pdf)
                                                                          <a class="ms-2" href="{{ $pdf }}" target="_blank" rel="noopener noreferrer">View</a><br>
                                                                      @endforeach
                                                                  @endif

                                                                </span>
                                                          </div>
                                                          </div>
                                                          <div class="section-heading">Inclusion
                                                              Additional</div>
                                                              @if (!empty($inclusionData['label']))
                                                                  @for ($i = 0; $i < count($inclusionData['label']); $i++)
                                                          <div class="col-lg-6">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Label</span>
                                                              <span
                                                                  class="sub-heading">

                                                                  {{ $inclusionData['label'][$i] ?? '' }}

                                                                </span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-6">
                                                              <div
                                                                  class="client-view-list">
                                                                  <span
                                                                      class="heading">Value</span>
                                                                  <span
                                                                      class="sub-heading">

                                                                      {{ $inclusionData['value'][$i] ?? '' }}

                                                                    </span>
                                                              </div>
                                                              </div>
                                                              @endfor
                                                                      @endif
                                                                      <div class="section-heading">Exclusion</div>
                                                          <div class="col-lg-3">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Label</span>
                                                              <span
                                                                  class="sub-heading">
                                                                  {{ $exclusion['label'] ?? '' }}

                                                                </span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-3">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Start Date</span>
                                                              <span
                                                                  class="sub-heading">
                                                                  {{ $exclusion['start_date'] ?? '' }}
                                                                </span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-3">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">End Date</span>
                                                              <span
                                                                  class="sub-heading">
                                                                  {{ $exclusion['end_date'] ?? '' }}
                                                                </span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-3">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">File</span>
                                                              <span
                                                                  class="sub-heading">
                                                                  @if (!empty($exclusion['pdf']) && is_array(json_decode($exclusion['pdf'], true)))
                                                                      @foreach (json_decode($exclusion['pdf'], true) as $pdf)
                                                                          <a class="ms-2" href="{{ $pdf }}" target="_blank" rel="noopener noreferrer">View</a><br>
                                                                      @endforeach
                                                                  @endif
                                                                </span>
                                                          </div>
                                                          </div>
                                                          <div class="section-heading">Exclusion
                                                              Additional</div>
                                                              @if (!empty($exclusionData['label']))
                                                                  @for ($i = 0; $i < count($exclusionData['label']); $i++)
                                                          <div class="col-lg-6">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Label</span>
                                                              <span
                                                                  class="sub-heading">

                                                                   {{ $exclusionData['label'][$i] ?? '' }}

                                                                </span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-6">
                                                          <div
                                                          class="client-view-list">
                                                          <span
                                                              class="heading">Value</span>
                                                          <span
                                                              class="sub-heading">
                                                               {{ $exclusionData['value'][$i] ?? '' }}

                                                            </span>
                                                      </div>
                                                          </div>
                                                          @endfor
                                                          @endif
                                                          <div class="section-heading">More Details</div>


                                                          @php
                                                              $stampingFiles = json_decode($d->stamping_vc, true) ?? [];
                                                              $brochureFiles = json_decode($d->brochure, true) ?? [];
                                                              $datasheetFiles = json_decode($d->datasheet, true) ?? [];
                                                          @endphp
                                                          <div class="col-lg-4">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Stamping
                                                                  VC</span>
                                                              <span
                                                                  class="sub-heading">
                                                                  @if (!empty($stampingFiles) && is_array(json_decode($stampingFiles, true)))
                                                                      @foreach (json_decode($stampingFiles, true) as $stampingFile)
                                                                          <a class="px-2" href="{{ asset($stampingFile) }}" target="_blank" rel="noopener noreferrer">View</a>
                                                                      @endforeach
                                                                  @endif

                                                            </span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-4">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Brochure</span>
                                                              <span
                                                                  class="sub-heading">
                                                                  @if (!empty($brochureFiles) && is_array($brochureFiles))
                                                                      @foreach ($brochureFiles as $brochureFile)
                                                                          <a class="px-2" href="{{ asset($brochureFile) }}" target="_blank" rel="noopener noreferrer">View</a>
                                                                      @endforeach
                                                                  @endif
                                                            </span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-4">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Datasheet</span>
                                                              <span
                                                                  class="sub-heading">
                                                                  @if (!empty($datasheetFiles) && is_array($datasheetFiles))
                                                                      @foreach ($datasheetFiles as $datasheetFile)
                                                                          <a class="px-2" href="{{ asset($datasheetFile) }}" target="_blank" rel="noopener noreferrer">View</a>
                                                                      @endforeach
                                                                  @endif

                                                            </span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-12">
                                                              <div
                                                                  class="client-view-list">
                                                                  <span
                                                                      class="heading">Specification</span>
                                                                  <span
                                                                      class="sub-heading">{{ $d->specification }}</span>
                                                              </div>
                                                              </div>
                                                              <div class="col-lg-12">
                                                              <div
                                                                  class="client-view-list">
                                                                  <span
                                                                      class="heading">Description</span>
                                                                  <span
                                                                      class="sub-heading">{{ $d->description }}</span>
                                                              </div>
                                                              </div>
                                                          <div class="col-lg-12">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Product
                                                                  Link</span>
                                                              <span
                                                                  class="sub-heading">
                                                                <a href="{{ $d->product_link }}" target="_blank" rel="noopener noreferrer">{{ $d->product_link }}</a>
                                                              </span>
                                                          </div>
                                                          </div>
                                                          <div class="section-heading">Additional</div>
                                                          @if (!empty($additionalData['label']))
                                                                  @for ($i = 0; $i < count($additionalData['label']); $i++)
                                                          <div class="col-lg-4">
                                                          <div
                                                              class="client-view-list">
                                                              <span
                                                                  class="heading">Label</span>
                                                              <span
                                                                  class="sub-heading">

                                                                   {{ $additionalData['label'][$i] ?? '' }}

                                                                </span>
                                                          </div>
                                                          </div>
                                                          <div class="col-lg-4">
                                                              <div
                                                                  class="client-view-list">
                                                                  <span
                                                                      class="heading">Type</span>
                                                                  <span
                                                                      class="sub-heading">

                                                                      {{ $additionalData['type'][$i] ?? '' }}

                                                                    </span>
                                                              </div>
                                                              </div>
                                                              <div class="col-lg-4">
                                                                  <div
                                                                      class="client-view-list">
                                                                      <span
                                                                          class="heading">Filed</span>
                                                                      <span
                                                                          class="sub-heading">

                                                                          {{ $additionalData['field'][$i] ?? '' }}

                                                                        </span>
                                                                  </div>
                                                                  </div>
                                                                  @endfor
                                                                  @endif
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  @endforeach
              @else
                  <tr>
                      <td>No
                          Record
                          Found
                      </td>
                  </tr>
              @endif
          </tbody>
      </table>
  </div>
@else
  <p class="textLeft">No Record
      Found</p>
@endif
