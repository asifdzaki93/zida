<?php
require_once 'data/koneksi.php'; // Menggunakan file koneksi yang sama
$sift = [];
$siftX = $mysqli->query("select * from sift order by name_sift asc");
while ($row = $siftX->fetch_assoc()) {
    array_push($sift, $row["name_sift"]);
}
?>


<div class="app-chat card overflow-hidden">
    <div class="row g-0">

        <!-- Chat History -->
        <div class="col app-chat-history">
            <div class="chat-history-wrapper">
                <!-- Chat message form -->
                <div class="chat-history-header border-bottom">
                    <form class="form-send-message d-flex justify-content-between align-items-center">
                        <input class="form-control message-input me-3 shadow-none" autofocus id="search_product_name" onchange="cariProduk()" placeholder="Cari Disini" />
                        <div class="message-actions d-flex align-items-center">
                            <select class="form-select" id="search_product_packages" onchange="cariProduk()">
                                <option value="">---</option>
                                <option value="YES">Paket</option>
                                <option value="NO">Bukan</option>
                            </select>

                            <button onclick="playTrash(); bersihkan()" class="btn btn-danger d-flex send-msg-btn ms-2">
                                <span class="mdi mdi-delete-empty"></span>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="chat-history-body">
                    <div class="row " id="search_product_list"></div>
                </div>
                <div class="row p-4">
                    <div class="col-2">

                        <select id="select_customer" class="form-control mb-2"></select>

                    </div>
                    <div class="col-2">
                        <input id="from-datepicker" class="form-control mb-2">
                    </div>
                    <div class="col-2">
                        <select id="jenis_pengiriman" class="form-control mb-2">
                            <?php
                            foreach ($sift as $s) {
                                echo "<option value='" . $s . "'>" . $s . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-4">
                        <input class="form-control message-input me-3 shadow-none" id="totalbayar" type="number" onchange="hitungSemua()">

                    </div>

                    <div class="col-1">

                        <button type="button" onclick="selesaiBuat()" class="btn btn-primary">
                            <span class="mdi mdi-file-document-outline"></span>
                        </button>

                    </div>
                    <div class="col-1">
                        <button type="button" onclick="playTrash(); loadPage('penjualan.php')" class="btn btn-danger ">
                            <span class="mdi mdi-file-cancel-outline"></span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
        <!-- /Chat History -->

        <!-- Chat & Contacts -->
        <div class="col app-chat-contacts flex-grow-0 overflow-hidden border-end">
            <div class="col app-chat-contacts app-sidebar flex-grow-0 overflow-hidden border-end" id="app-chat-contacts">
                <div class="sidebar-header py-3 px-4 border-bottom">
                    <div class="d-flex align-items-center me-3 me-lg-0">
                        <div class="flex-shrink-0 avatar avatar-online me-3" data-bs-toggle="sidebar" data-overlay="app-overlay-ex" data-target="#app-chat-sidebar-left">
                            <img class="user-avatar rounded-circle cursor-pointer" src="<?php echo $base_url; ?>/assets/img/avatars/1.png" alt="Avatar" />
                        </div>
                        <div class="flex-grow-1 input-group input-group-merge rounded-pill">
                            <span class="input-group-text" id="basic-addon-search31"><i class="mdi mdi-magnify lh-1"></i></span>
                            <input type="text" class="form-control chat-search-input" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31" />
                        </div>
                    </div>
                    <i class="mdi mdi-close mdi-20px cursor-pointer position-absolute top-0 end-0 mt-2 me-2 fs-4 d-lg-none d-block" data-overlay data-bs-toggle="sidebar" data-target="#app-chat-contacts"></i>
                </div>

                <div class="sidebar-body">
                    <div id="baru">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead class="table-light border-top">
                                    <tr>
                                        <th>Item</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="produkDibeli"></tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total Order</th>
                                        <th class="text-success">Rp 0</th>
                                    </tr>

                                    <tr>
                                        <th>Tagihan / Sisa</th>
                                        <th id="tagihansisa" class="text-success">Rp 0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="card-footer d-flex">

                        </div>



                    </div>
                </div>

            </div>
        </div>
        <!-- /Chat contacts -->
        <div class="app-overlay"></div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="selesai_buat" tabindex="-1" aria-labelledby="selesai_buat_label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selesai_buat_label">Konfirmasi Pembuatan Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                Apakah kamu yakin untuk menyimpan data?
            </div>
            <div class="modal-footer">
                <button type="button" onclick="selesaiBuatKonfirmasi()" class="btn btn-primary">Konfirmasi</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Edit Ulang</button>
                <button type="button" onclick="loadPage('penjualan.php')" class="btn btn-danger" data-bs-dismiss="modal">Kembali Ke Penjualan</button>
            </div>
        </div>
    </div>
</div>

<script>
    $("#select_customer").select2({
        ajax: {
            url: "<?php echo $base_url; ?>/admin/data/cari_customer.php",
            type: "GET",
            data: function(params) {

                var queryParameters = {
                    search: params.term
                }
                return queryParameters;
            },
        }
    });
    $("#select_operator").select2({
        ajax: {
            url: "<?php echo $base_url; ?>/admin/data/cari_operator.php",
            type: "GET",
            data: function(params) {

                var queryParameters = {
                    search: params.term
                }
                return queryParameters;
            },
        }
    });

    function formatRupiah(angkaX) {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
            currency: "IDR"
        }).format(angkaX);
    }

    function bersihkan() {
        $("#produkDibeli").html("");
        hitungSemua();
    }

    function hitungSemua() {
        var total = 0;
        $(".product_total").each(function(index) {
            total += $(this).val() * 1;
        })
        $("#totalorder").html(formatRupiah(total));
        total -= $("#totalbayar").val() * 1;
        $("#tagihansisa").html(formatRupiah(total));
    }

    function hitungProduct(id) {
        total = $("#product_" + id + "_amount").val() * $("#product_" + id + "_selling_price").val();

        $("#product_" + id + "_total").val(total);
        $("#product_" + id + "_total_label").html(formatRupiah(total))
        hitungSemua();
    }

    function pilihProduct(id) {
        var amountterpilih = $("#product_" + id + "_amount").val();
        if (amountterpilih == null) {
            amountterpilih = 0;
            $("#produkDibeli").append(
                $("<tr></tr>").attr("class", "product_dibeli").attr("id", "product_" + id).append(
                    $("<td></td>").append(
                        $("#dataproduct_" + id + "_name").val(),
                        $("<div></div>").attr("class", "input-group input-group-sm").append(
                            $.parseHTML(
                                '<button type="button" class="btn btn-primary" ' +
                                'onclick=\'playSound(); hapusProduk("' + id + '")\'' +
                                '><span class = "fa fa-subtract"> </span></button>'
                            ),
                            $("<input>").attr("class", "form-control").attr("id", "product_" + id + "_amount")
                            .attr("type", "number").attr('disabled', true),
                            $.parseHTML(
                                '<button type="button" class="btn btn-primary" ' +
                                'onclick=\'playSound(); pilihProduct("' + id + '")\'' +
                                '><span class = "fa fa-add"> </span></button>'
                            ),

                        )
                    ),
                    $("<td></td>").append(
                        $("<input>").attr("id", "product_" + id + "_selling_price")
                        .attr("type", "hidden").val($("#dataproduct_" + id + "_selling_price").val()),
                        $("<input>").attr("id", "product_" + id + "_total")
                        .attr("type", "hidden").attr("class", "product_total"),
                        $("<b></b>").attr("class", "text-primary").attr("id", "product_" + id + "_total_label")
                    ),
                )
            );
        }
        $("#product_" + id + "_amount").val(amountterpilih * 1 + 1)
        hitungProduct(id);
    }

    function hapusProduk(id) {
        var amountterpilih = $("#product_" + id + "_amount").val();
        if (amountterpilih > 1) {
            $("#product_" + id + "_amount").val(amountterpilih * 1 - 1)
            hitungProduct(id);
        } else {
            $("#product_" + id).remove();
        }
    }



    function trimText(text, limit) {
        var words = text.split(' ');
        if (words.length > limit) {
            return words.slice(0, limit).join(' ') + '...';
        } else {
            return text;
        }
    }


    function formatRupiah(number) {
        // Fungsi untuk format rupiah
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(number);
    }

    async function cariProduk() {
        $("#search_product_list").html("<tr><td colspan=5>Tidak Ada Produk</td></tr>");
        var name_product = $("#search_product_name").val();
        var packages = $("#search_product_packages").val();
        await $.ajax({
            url: "<?php echo $base_url; ?>/admin/data/cari_produk.php?name_product=" + name_product +
                "&packages=" + packages,
            success: function(resultX) {
                var result = resultX.products;
                $("#search_product_list").html("");
                for (var i = 0; i < result.length; i++) {
                    $("#search_product_list").append(
                        $("<div></div>").attr("class", "col-md-6 mb-3").append(
                            $("<div></div>").attr("class", "card position-relative").append(
                                $("<div></div>").attr("class", "row g-0").append(
                                    $("<div></div>").attr("class", "col-md-4").append(
                                        $("<img>").attr("class", "card-img card-img-left").attr("src", result[i].img).attr("alt", "Card image")
                                    ),
                                    $("<div></div>").attr("class", "col-md-8").append(
                                        $("<div></div>").attr("class", "card-body").append(
                                            $("<h5></h5>").attr("class", "card-title").html(trimText(result[i].name_product, 4)),
                                            $("<p></p>").attr("class", "card-text").html(trimText(result[i].description, 7)),
                                            $("<p></p>").attr("class", "card-text price-text").html(formatRupiah(result[i].selling_price))
                                        )
                                    )
                                ),
                                $("<button></button>").attr("class", "btn btn-primary btn-sm floating-btn").attr("onclick", "playSound(); pilihProduct('" + result[i].id_product + "')").html("<i class='fas fa-plus'></i>")
                                //$("<button></button>").attr("class", "btn btn-primary btn-sm floating-btn").html("<i class='fas fa-plus'></i>").attr("onclick", " playSound(); pilihProduct('" + result[i].id_product + "')")
                            )
                        )
                    );
                }
            }
        });
    }

    function playSound() {
        var audio = document.getElementById('beepSound');
        audio.play();
    }

    function playTrash() {
        var audio = document.getElementById('trash');
        audio.play();
    }

    function trimText(text, limit) {
        // Memisahkan teks berdasarkan spasi, titik, atau koma
        var words = text.split(/[\s,\.]+/);
        if (words.length > limit) {
            return words.slice(0, limit).join(' ') + '...';
        } else {
            return text;
        }
    }


    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(number);
    }


    cariProduk();

    async function hapusProdukKonfirmasi() {
        $("#hapus_produk").modal("hide");
        var id_sales = $("#hapus_produk_id").val();
        await $.ajax({
            url: "<?php echo $base_url; ?>/admin/data/hapus_produk.php?id_sales=" + id_sales,
            success: function(resultX) {
                if (resultX == "success") {
                    refreshPage();
                } else {
                    alert(resultX);
                }
            }
        });
    }

    function selesaiBuat() {
        $("#selesai_buat").modal("show");
    }
    async function selesaiBuatKonfirmasi() {
        $("#selesai_buat").modal("hide");
        var customer = $("#select_customer").val();
        if (customer == null || customer == "") {
            alert("Kustomer belum terisi!");
            return;
        }
        var operator = $("#select_operator").val();
        if (operator == null || operator == "") {
            alert("Operator belum terisi!");
            return;
        }
        var product_dibeli = [];
        $(".product_dibeli").each(function(index) {
            var id = $(this).attr("id").replace("product_", "");
            var amount = $("#product_" + id + "_amount").val();
            product_dibeli.push(id.toString() + ":" + amount.toString())
        })
        var data = {
            "id_customer": customer,
            "operator": operator,
            "catatan": $("#catatan").val(),
            "due_date": $("#from-datepicker").val(),
            "jenis_pengiriman": $("#jenis_pengiriman").val(),
            "jam_acara": $("#jam_acara").val(),
            "totalpay": $("#totalbayar").val(),
            "product_dibeli": product_dibeli.join(",")
        };
        await $.ajax({
            url: "<?php echo $base_url; ?>/admin/data/create_invoice.php",
            data: data,
            method: "post",
            success: function(resultX) {
                var result = resultX.split("|")[0];
                var no_invoice = resultX.split("|")[1];
                if (result == "success" && no_invoice != null) {
                    loadPage("order_detail.php?no_invoice=" + no_invoice);
                } else {
                    alert(resultX);
                }
            }
        });
    }




    const chatContactsBody = document.querySelector('.app-chat-contacts .sidebar-body'),
        chatContactListItems = [].slice.call(
            document.querySelectorAll('.chat-contact-list-item:not(.chat-contact-list-item-title)')
        ),
        baru = document.querySelector('#inv'),
        chatHistoryBody = document.querySelector('.chat-history-body'),
        chatSidebarLeftBody = document.querySelector('.app-chat-sidebar-left .sidebar-body'),
        chatSidebarRightBody = document.querySelector('.app-chat-sidebar-right .sidebar-body'),
        chatUserStatus = [].slice.call(document.querySelectorAll(".form-check-input[name='chat-user-status']")),
        chatSidebarLeftUserAbout = $('.chat-sidebar-left-user-about'),
        formSendMessage = document.querySelector('.form-send-message'),
        messageInput = document.querySelector('.message-input'),
        searchInput = document.querySelector('.chat-search-input'),
        speechToText = $('.speech-to-text'), // ! jQuery dependency for speech to text
        userStatusObj = {
            active: 'avatar-online',
            offline: 'avatar-offline',
            away: 'avatar-away',
            busy: 'avatar-busy'
        };

    // Initialize PerfectScrollbar
    // ------------------------------

    // Chat contacts scrollbar
    if (chatContactsBody) {
        new PerfectScrollbar(chatContactsBody, {
            wheelPropagation: false,
            suppressScrollX: true
        });
    }

    // Chat contacts scrollbar
    if (baru) {
        new PerfectScrollbar(baru, {
            wheelPropagation: false,
            suppressScrollX: true
        });
    }

    // Chat history scrollbar
    if (chatHistoryBody) {
        new PerfectScrollbar(chatHistoryBody, {
            wheelPropagation: false,
            suppressScrollX: true
        });
    }

    // Sidebar left scrollbar
    if (chatSidebarLeftBody) {
        new PerfectScrollbar(chatSidebarLeftBody, {
            wheelPropagation: false,
            suppressScrollX: true
        });
    }

    // Sidebar right scrollbar
    if (chatSidebarRightBody) {
        new PerfectScrollbar(chatSidebarRightBody, {
            wheelPropagation: false,
            suppressScrollX: true
        });
    }

    // Scroll to bottom function
    function scrollToBottom() {
        chatHistoryBody.scrollTo(0, chatHistoryBody.scrollHeight);
    }
    scrollToBottom();

    // User About Maxlength Init
    if (chatSidebarLeftUserAbout.length) {
        chatSidebarLeftUserAbout.maxlength({
            alwaysShow: true,
            warningClass: 'label label-success bg-success text-white',
            limitReachedClass: 'label label-danger',
            separator: '/',
            validate: true,
            threshold: 120
        });
    }

    // Update user status
    chatUserStatus.forEach(el => {
        el.addEventListener('click', e => {
            let chatLeftSidebarUserAvatar = document.querySelector('.chat-sidebar-left-user .avatar'),
                value = e.currentTarget.value;
            //Update status in left sidebar user avatar
            chatLeftSidebarUserAvatar.removeAttribute('class');
            Helpers._addClass('avatar avatar-xl w-px-75 h-px-75 ' + userStatusObj[value] + '', chatLeftSidebarUserAvatar);
            //Update status in contacts sidebar user avatar
            let chatContactsUserAvatar = document.querySelector('.app-chat-contacts .avatar');
            chatContactsUserAvatar.removeAttribute('class');
            Helpers._addClass('flex-shrink-0 avatar ' + userStatusObj[value] + ' me-3', chatContactsUserAvatar);
        });
    });

    // Select chat or contact
    chatContactListItems.forEach(chatContactListItem => {
        // Bind click event to each chat contact list item
        chatContactListItem.addEventListener('click', e => {
            // Remove active class from chat contact list item
            chatContactListItems.forEach(chatContactListItem => {
                chatContactListItem.classList.remove('active');
            });
            // Add active class to current chat contact list item
            e.currentTarget.classList.add('active');
        });
    });

    // Filter Chats
    if (searchInput) {
        searchInput.addEventListener('keyup', e => {
            let searchValue = e.currentTarget.value.toLowerCase(),
                searchChatListItemsCount = 0,
                searchContactListItemsCount = 0,
                chatListItem0 = document.querySelector('.chat-list-item-0'),
                contactListItem0 = document.querySelector('.contact-list-item-0'),
                searchChatListItems = [].slice.call(
                    document.querySelectorAll('#chat-list li:not(.chat-contact-list-item-title)')
                ),
                searchContactListItems = [].slice.call(
                    document.querySelectorAll('#contact-list li:not(.chat-contact-list-item-title)')
                );

            // Search in chats
            searchChatContacts(searchChatListItems, searchChatListItemsCount, searchValue, chatListItem0);
            // Search in contacts
            searchChatContacts(searchContactListItems, searchContactListItemsCount, searchValue, contactListItem0);
        });
    }

    // Search chat and contacts function
    function searchChatContacts(searchListItems, searchListItemsCount, searchValue, listItem0) {
        searchListItems.forEach(searchListItem => {
            let searchListItemText = searchListItem.textContent.toLowerCase();
            if (searchValue) {
                if (-1 < searchListItemText.indexOf(searchValue)) {
                    searchListItem.classList.add('d-flex');
                    searchListItem.classList.remove('d-none');
                    searchListItemsCount++;
                } else {
                    searchListItem.classList.add('d-none');
                }
            } else {
                searchListItem.classList.add('d-flex');
                searchListItem.classList.remove('d-none');
                searchListItemsCount++;
            }
        });
        // Display no search fount if searchListItemsCount == 0
        if (searchListItemsCount == 0) {
            listItem0.classList.remove('d-none');
        } else {
            listItem0.classList.add('d-none');
        }
    }

    // Send Message
    formSendMessage.addEventListener('submit', e => {
        e.preventDefault();
        if (messageInput.value) {
            // Create a div and add a class
            let renderMsg = document.createElement('div');
            renderMsg.className = 'chat-message-text mt-3';
            renderMsg.innerHTML = '<p class="mb-0">' + messageInput.value + '</p>';
            document.querySelector('li:last-child .chat-message-wrapper').appendChild(renderMsg);
            messageInput.value = '';
            scrollToBottom();
        }
    });

    // on click of chatHistoryHeaderMenu, Remove data-overlay attribute from chatSidebarLeftClose to resolve overlay overlapping issue for two sidebar
    let chatHistoryHeaderMenu = document.querySelector(".chat-history-header [data-target='#app-chat-contacts']"),
        chatSidebarLeftClose = document.querySelector('.app-chat-sidebar-left .close-sidebar');
    chatHistoryHeaderMenu.addEventListener('click', e => {
        chatSidebarLeftClose.removeAttribute('data-overlay');
    });
    // }

    // Speech To Text
    if (speechToText.length) {
        var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;
        if (SpeechRecognition !== undefined && SpeechRecognition !== null) {
            var recognition = new SpeechRecognition(),
                listening = false;
            speechToText.on('click', function() {
                const $this = $(this);
                recognition.onspeechstart = function() {
                    listening = true;
                };
                if (listening === false) {
                    recognition.start();
                }
                recognition.onerror = function(event) {
                    listening = false;
                };
                recognition.onresult = function(event) {
                    $this.closest('.form-send-message').find('.message-input').val(event.results[0][0].transcript);
                };
                recognition.onspeechend = function(event) {
                    listening = false;
                    recognition.stop();
                };
            });
        }
    }
</script>