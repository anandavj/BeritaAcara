<?php require('template/header.php'); ?>
    <title>Home</title>
    </head>
	<body>
		<div id="app">
			<v-app>
				<?php require('template/navbar.php') ?>
				<v-content>
					<v-layout fill-height>
                        <v-container fluid>
                            <v-row align="center">
								<v-col cols="12" sm="12" md="3">
                                    <v-card @click="verifikasiDialog = !verifikasiDialog" class="elevation-12 align-center" color="blue" min-height="230" max-height="230">
                                        <div class="d-flex flex-no-wrap justify-space-between">
											<div>
												<v-card-title class="font-weight-light">VERIFIKASI MAHASISWA</v-card-title>
											</div>
											<div>
												<v-card-title class="font-weight-light"><v-icon>mdi-format-list-checks</v-icon></v-card-title>
											</div>
										</div>
										<v-card-title class="justify-center"><v-icon class="display-4">mdi-account-check</v-icon></v-card-title>
                                    </v-card>
                                </v-col>
								<v-dialog v-model='verifikasiDialog' fullscreen hide-overlay transition="dialog-bottom-transition">
									<v-card>
										<v-toolbar dense flat color="blue">
											<span class="title font-weight-light">Verifikasi Mahasiswa</span>
											<v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
										</v-toolbar>
										<v-card-text>
											<v-data-table
												:headers="verifikasiHeader"
												:items="listUnverifiedUsers"
												:mobile-breakpoint="1"
												item-key="id"
												show-select
												v-model="selectedForVerify"
											>
											<template v-slot:item.date="{item}">
												<span>{{ dateFormat(item.date) }}</span>
											</template>
											</v-data-table>
											<v-card-actions>
                                                <v-container>
													<v-row justify="center">
														<v-col sm="8" md="4" xl="2" class='text-center'>
															<v-btn color="green white--text" width='100%' :disabled="selectedForVerify.length == 0" @click="verifyNow">Aktifkan Akun</v-btn>
														</v-col>
                                                    </v-row>
                                                </v-container>
                                            </v-card-actions>
										</v-card-text>
									</v-card>
								</v-dialog>
								<v-col cols="12" sm="12" md="3">
                                    <v-card @click="createNewDosenDialog = !createNewDosenDialog" class="elevation-12 align-center" color="blue" min-height="230" max-height="230">
                                        <div class="d-flex flex-no-wrap justify-space-between">
											<div>
												<v-card-title class="font-weight-light">ADD DOSEN</v-card-title>
											</div>
											<div>
												<v-card-title class="font-weight-light"><v-icon>mdi-account</v-icon></v-card-title>
											</div>
										</div>
										<v-card-title class="justify-center"><v-icon class="display-4">mdi-account-plus</v-icon></v-card-title>
                                    </v-card>
                                </v-col>
								<v-dialog v-model="createNewDosenDialog" persistent max-width="800px">
									<v-toolbar dense flat color="blue">
										<span class="title font-weight-light">Create New User</span>
										<v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
									</v-toolbar>
									<v-form ref="form" class="px-2">
										<v-card-text>
											<v-row>
												<v-col cols="12">
													<v-text-field class="mb-n4" color="blue" label="NIP / NIM" v-model="user.nomor" :rules="rules.nomor"/>
												</v-col>
												<v-col cols="12">
													<v-text-field class="mb-n4" color="blue" label="Nama" v-model="user.nama" :rules="rules.nama"/>
												</v-col>
												<v-col cols="12">
													<v-text-field class="mb-n4" color="blue" label="Email" v-model="user.email" :rules="rules.email"/>
												</v-col>
											</v-row>
										</v-card-text>
									</v-form>
									<v-card-actions>
										<v-container>
											<v-row justify="center">
												<v-btn class="mt-n8" color="red darken-1" text @click="close">Cancel</v-btn>
												<v-btn class="mt-n8" color="green white--text" @click="createNewUser">Create</v-btn>
											</v-row>
										</v-container>
									</v-card-actions>
								</v-dialog>
								<v-col cols="12" sm="12" md="3">
                                    <v-card @click="eventSidangDialog = !eventSidangDialog" class="elevation-12 align-center" color="blue" min-height="230" max-height="230">
                                        <div class="d-flex flex-no-wrap justify-space-between">
											<div>
												<v-card-title class="font-weight-light">EVENT SIDANG</v-card-title>
											</div>
											<div>
												<v-card-title class="font-weight-light"><v-icon>mdi-calendar-blank-multiple</v-icon></v-card-title>
											</div>
										</div>
										<v-card-title class="justify-center"><v-icon class="display-4">mdi-calendar-clock</v-icon></v-card-title>
                                    </v-card>
                                </v-col>
								<v-dialog v-model="eventSidangDialog" persistent max-width="700px">
									<v-card>
										<v-toolbar dense flat color="blue">
											<span class="title font-weight-light">Event Sidang</span>
											<v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
										</v-toolbar>
										<v-form ref="dateForm">
											<v-card-text>
												<v-row align="center" justify="center">
													<v-col cols='12'>
														<v-menu
															ref="showDatePickerStart"
															v-model="showDatePickerStart"
															:close-on-content-click="false"
															transition="scale-transition"
															offset-y
															min-width="290px"
														>
															<template v-slot:activator="{ on }">
																<v-text-field
																label="Tanggal Mulai"
																append-icon="mdi-calendar"
																:value="formatDate"
																readonly
																v-on="on"
																outlined
																dense
																:clearable="true"
																@click:clear="event[0].tanggal_mulai = null"
																class="mb-n6 mt-1"
																></v-text-field>
															</template>
															<v-date-picker v-model="event[0].tanggal_mulai"  no-title scrollable :weekday-format="dayFormat" @change="showDatePickerStart = false">
															</v-date-picker>
														</v-menu>
													</v-col>
													<v-col cols='12'>
														<v-menu
															ref="showDatePickerEnd"
															v-model="showDatePickerEnd"
															:close-on-content-click="false"
															transition="scale-transition"
															offset-y
															min-width="290px"
														>
															<template v-slot:activator="{ on }">
																<v-text-field
																label="Tanggal Berakhir"
																append-icon="mdi-calendar"
																:value="formatDateEnd"
																readonly
																v-on="on"
																outlined
																dense
																:clearable="true"
																@click:clear="event[0].tanggal_berakhir = null"
																class="mb-n6 mt-1"
																></v-text-field>
															</template>
															<v-date-picker v-model="event[0].tanggal_berakhir"  no-title scrollable :weekday-format="dayFormat" @change="showDatePickerEnd = false">
															</v-date-picker>
														</v-menu>
													</v-col>
												</v-row>
											</v-card-text>
										</v-form>
										<v-card-actions>
											<v-container>
												<v-row justify="center">
													<v-btn class="mt-n8" color="red darken-1" text @click="close">Cancel</v-btn>
													<v-btn class="mt-n8" color="green white--text" @click="updateEvent">Update</v-btn>
												</v-row>
											</v-container>
										</v-card-actions>
									</v-card>
								</v-dialog>
								<v-col cols="12" sm="12" md="3">
                                    <v-card @click="listMahasiswaDialog = !listMahasiswaDialog" class="elevation-12 align-center" color="blue" min-height="230" max-height="230">
                                        <div class="d-flex flex-no-wrap justify-space-between">
											<div>
												<v-card-title class="font-weight-light">LIST MAHASISWA</v-card-title>
											</div>
											<div>
												<v-card-title class="font-weight-light"><v-icon>mdi-account-details</v-icon></v-card-title>
											</div>
										</div>
										<v-card-title class="justify-center"><v-icon class="display-4">mdi-account-multiple</v-icon></v-card-title>
                                    </v-card>
                                </v-col>
								<v-dialog v-model="listMahasiswaDialog" fullscreen hide-overlay transition="dialog-bottom-transition">
									<v-card>
										<v-toolbar dense flat color="blue">
											<span class="title font-weight-light">Event Sidang</span>
											<v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
										</v-toolbar>
										<v-text-field
											placeholder="NIM / Nama Mahasiswa"
											:solo='true'
											:clearable='true'
											append-icon="mdi-magnify"
											class="font-regular font-weight-light mt-8 mb-n4 mx-8"
											v-model="searchMahasiswa"
										></v-text-field>
										<v-data-table
											:headers="mahasiswaHeader"
											:items="listMahasiswa"
											:mobile-breakpoint="1"
											@click:row="detailMahasiswa"
											:search="searchMahasiswa"
											style="cursor:pointer"
										></v-data-table>
									</v-card>
								</v-dialog>
								<v-dialog v-model="detailMahasiswaDialog" persistent max-width="700px">
									<v-card>
										<v-toolbar dense flat color="blue">
											<span class="title font-weight-light">Detail Mahasiswa</span>
											<v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
										</v-toolbar>
										<v-form ref="mahasiswaForm">
											<v-card-text>
												<v-row justify="end" class="pr-4">
													<v-chip @click="changePasswordDefaultDialog = !changePasswordDefaultDialog" label dense class="mb-n4 pa-n4" color="transparent orange--text">Klik Disini Untuk Reset Password</v-chip>
												</v-row>
												<v-row justify="end" class="pr-4 mt-4">
													<v-chip @click="resetBerkasDialog = !resetBerkasDialog" label dense class="mb-n4 pa-n4" color="transparent orange--text">Klik Disini Untuk Reset Berkas</v-chip>
												</v-row>
												<v-col cols="12">
													<v-text-field class="mb-n6" color="blue" label="NIM" v-model="mahasiswa.nomor" :rules="rules.nomor"/>
												</v-col>
												<v-col cols="12">
													<v-text-field class="mb-n4" color="blue" label="Nama" v-model="mahasiswa.nama" :rules="rules.nama"/>
												</v-col>
												<v-col cols="12">
													<v-textarea class="mb-n4" color="blue" label="Judul" :auto-grow="true" rows="1" v-model="mahasiswa.judul"/>
												</v-col>
												<v-col cols="12">
													<v-autocomplete
														v-model="mahasiswa.id_dosen_pembimbing"
														:items="listDosen"
														label="Dosen Pembimbing"
														chips
														dense
														:clearable="true"
														:auto-select-first="true"
														color="blue"
														item-color="blue"
														:search-input.sync="dosenPembimbingInput"
														@change="dosenPembimbingInput=''"
														item-text="nama"
														item-value="id"
														:readonly="mahasiswa.id_dosen_pembimbing != null"
														@click:clear="mahasiswa.id_dosen_pembimbing = null"
														class="mb-n2"
													>
													<template v-slot:selection="data">
														<v-chip color="transparent" class="pa-0">
															{{data.item.nama}}
														</v-chip>
													</template>
													</v-autocomplete>
												</v-col>
												<v-col cols="12">
													<v-autocomplete
														v-model="mahasiswa.id_ketua_penguji"
														:items="listDosen"
														label="Ketua Penguji"
														chips
														dense
														:clearable="true"
														:auto-select-first="true"
														color="blue"
														item-color="blue"
														:search-input.sync="ketuaDosenPengujiInput"
														@change="ketuaDosenPengujiInput=''"
														item-text="nama"
														item-value="id"
														:readonly="mahasiswa.id_ketua_penguji != null"
														@click:clear="mahasiswa.id_ketua_penguji = null"
														class="mb-n2"
													>
													<template v-slot:selection="data">
														<v-chip color="transparent" class="pa-0">
															{{data.item.nama}}
														</v-chip>
													</template>
													</v-autocomplete>
												</v-col>
												<v-col cols="12">
													<v-autocomplete
														v-model="mahasiswa.id_dosen_penguji"
														:items="listDosen"
														label="Dosen Penguji"
														chips
														dense
														:clearable="true"
														:auto-select-first="true"
														color="blue"
														item-color="blue"
														:search-input.sync="dosenPengujiInput"
														@change="dosenPengujiInput=''"
														item-text="nama"
														item-value="id"
														:readonly="mahasiswa.id_dosen_penguji != null"
														@click:clear="mahasiswa.id_dosen_penguji = null"
														class="mb-n2"
													>
													<template v-slot:selection="data">
														<v-chip color="transparent" class="pa-0">
															{{data.item.nama}}
														</v-chip>
													</template>
													</v-autocomplete>
												</v-col>
												<v-col cols='12'>
													<v-simple-table class="mx-n4">
														<template v-slot:default>
															<tbody>
																<tr>
																	<td class="font-weight-bold">BERKAS SKRIPSI</td>
																	<td>
																		<v-icon @click.stop="goToSkripsi" class='blue--text'>mdi-file</v-icon>
																		<span class="mx-4">||</span>
																		<v-icon @click="verify('skripsi_file_verified',0)" class="mr-4 red--text" :disabled="mahasiswa.berkas[0].skripsi_file_verified_ketua_penguji == 0">mdi-close</v-icon>
																		<v-icon @click="verify('skripsi_file_verified',1)" class="mr-4 green--text" :disabled="mahasiswa.berkas[0].skripsi_file_verified_ketua_penguji == 1">mdi-check</v-icon>
																		<span v-if="mahasiswa.berkas[0].skripsi_file_verified_ketua_penguji == 0" class="red--text">Revisi</span>
                                                                    	<span v-if="mahasiswa.berkas[0].skripsi_file_verified_ketua_penguji == 1" class="green--text">Diterima</span>
																	</td>
																</tr>
																<tr>
																	<td class="font-weight-bold">BERKAS TOEFL</td>
																	<td>
																		<v-icon @click.stop="goToToefl" class='blue--text'>mdi-file</v-icon>
																		<span class="mx-4">||</span>
																		<v-icon @click="verify('toefl_file_verified',0)" class="mr-4 red--text" :disabled="mahasiswa.berkas[0].toefl_file_verified == 0">mdi-close</v-icon>
																		<v-icon @click="verify('toefl_file_verified',1)" class="mr-4 green--text" :disabled="mahasiswa.berkas[0].toefl_file_verified == 1">mdi-check</v-icon>
																		<span v-if="mahasiswa.berkas[0].toefl_file_verified == 0" class="red--text">Revisi</span>
																		<span v-if="mahasiswa.berkas[0].toefl_file_verified == 1" class="green--text">Diterima</span>
																	</td>
																</tr>
																<tr>
																	<td class="font-weight-bold">TRANSKRIP</td>
																	<td>
																		<v-icon @click.stop="goToTranskrip" class='blue--text'>mdi-file</v-icon>
																		<span class="mx-4">||</span>
																		<v-icon @click="verify('transkrip_file_verified',0)" class="mr-4 red--text" :disabled="mahasiswa.berkas[0].transkrip_file_verified == 0">mdi-close</v-icon>
																		<v-icon @click="verify('transkrip_file_verified',1)" class="mr-4 green--text" :disabled="mahasiswa.berkas[0].transkrip_file_verified == 1">mdi-check</v-icon>
																		<span v-if="mahasiswa.berkas[0].transkrip_file_verified == 0" class="red--text">Revisi</span>
																		<span v-if="mahasiswa.berkas[0].transkrip_file_verified == 1" class="green--text">Diterima</span>
																	</td>
																</tr>
																<tr>
																	<td class="font-weight-bold">KARTU BIMBINGAN</td>
																	<td>
																		<v-icon @click.stop="goToBimbingan" class='blue--text'>mdi-file</v-icon>
																		<span class="mx-4">||</span>
																		<v-icon @click="verify('bimbingan_file_verified',0)" class="mr-4 red--text" :disabled="mahasiswa.berkas[0].bimbingan_file_verified == 0">mdi-close</v-icon>
																		<v-icon @click="verify('bimbingan_file_verified',1)" class="mr-4 green--text" :disabled="mahasiswa.berkas[0].bimbingan_file_verified == 1">mdi-check</v-icon>
																		<span v-if="mahasiswa.berkas[0].bimbingan_file_verified == 0" class="red--text">Revisi</span>
																		<span v-if="mahasiswa.berkas[0].bimbingan_file_verified == 1" class="green--text">Diterima</span>
																	</td>
																</tr>
															</tbody>
														</template>
													</v-simple-table>
												</v-col>
											</v-card-text>
										</v-form>
										<v-card-actions>
											<v-container>
												<v-row justify="center">
													<v-btn class="mt-n8" color="red darken-1" text @click="close">Cancel</v-btn>
													<v-btn class="mt-n8" color="green white--text" @click="updateMahasiswa">Update</v-btn>
												</v-row>
											</v-container>
										</v-card-actions>
									</v-card>
								</v-dialog>
								<v-dialog style="z-index:999" v-model="changePasswordDefaultDialog" persistent max-width="500px">
									<v-card>
										<v-card-title>Konfirmasi</v-card-title>
										<v-card-text>Apakah Anda Yakin Ingin Reset Password {{mahasiswa.nama}}?</v-card-text>
										<v-card-actions>
											<v-container>
												<v-row justify="center">
													<v-btn class="mt-n5" color="red darken-1" text @click="changePasswordDefaultDialog = false">Tidak</v-btn>
													<v-btn class="mt-n5" color="blue darken-1" text @click="changePasswordDefault">Ya</v-btn>
												</v-row>
											</v-container>
										</v-card-actions>
									</v-card>
								</v-dialog>
								<v-dialog style="z-index:999" v-model="resetBerkasDialog" persistent max-width="500px">
									<v-card>
										<v-card-title>Konfirmasi</v-card-title>
										<v-card-text>Apakah Anda Yakin Ingin Reset Berkas {{mahasiswa.nama}}?</v-card-text>
										<v-card-actions>
											<v-container>
												<v-row justify="center">
													<v-btn class="mt-n5" color="red darken-1" text @click="resetBerkasDialog = false">Tidak</v-btn>
													<v-btn class="mt-n5" color="blue darken-1" text @click="resetBerkas">Ya</v-btn>
												</v-row>
											</v-container>
										</v-card-actions>
									</v-card>
								</v-dialog>
								<v-dialog persistent v-model="changePasswordOpenDialog" max-width="700px">
                                    <v-card>
                                        <v-toolbar dense flat color="blue">
                                            <span class="title font-weight-light">Ganti Password</span>
                                            <v-btn absolute right icon @click="close"><v-icon>mdi-close</v-icon></v-btn>
                                        </v-toolbar>
                                        <v-form ref="formPassword" class="px-2">
                                            <v-card-text>
                                                <v-row>
                                                    <v-col>
                                                    <v-col cols="12">
                                                        <v-text-field
                                                            v-model="passwordAfter"
                                                            label="Password Baru"
                                                            :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                                            :type="showPassword ? 'text' : 'password'"
                                                            @click:append="showPassword = !showPassword"
                                                            :rules='rules.passwordAfter'
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12">
                                                        <v-text-field
                                                            v-model="passwordAfterConfirmation"
                                                            label="Konfirmasi Password"
                                                            :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                                            :type="showPassword ? 'text' : 'password'"
                                                            @click:append="showPassword = !showPassword"
                                                            :rules='rules.passwordConfirm'
                                                        ></v-text-field>
                                                    </v-col>
                                                </v-row>
                                            </v-card-text>
                                        </v-form>
                                        <v-card-actions>
                                            <v-container>
                                                <v-row justify="center">
                                                    <v-btn class="mt-n8" color="red darken-1" text @click="close">Cancel</v-btn>
                                                    <v-btn class="mt-n8" color="green white--text" @click="changePassword">Change Password</v-btn>
                                                </v-row>
                                            </v-container>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>
                            </v-row>
                        </v-container>
                    </v-layout>
					<v-snackbar
                        v-model="snackbar"
                        multi-line
                        v-bind:color="snackbarColor"
                    >
                        {{ snackbarMessage }}
                        <v-btn
                            text
                            @click="snackbar = false"
                        >
                            <v-icon>
                                mdi-close
                            </v-icon>
                        </v-btn>
                    </v-snackbar>
				</v-content>
			</v-app>
		</div>

		<script>
			new Vue({
				el: '#app',
				vuetify: new Vuetify(),

				created() { 
					this.$vuetify.theme.dark = true
				},

				mounted() {
					this.get()
				},

				data() {
					return {
						// Search
						searchMahasiswa:'',
						dosenPembimbingInput:'',
						ketuaDosenPengujiInput:'',
						dosenPengujiInput:'',
						// Dialog
						verifikasiDialog: false,
						createNewDosenDialog: false,
						eventSidangDialog: false,
						showDatePickerStart: false,
						showDatePickerEnd: false,
						listMahasiswaDialog: false,
						detailMahasiswaDialog: false,
						changePasswordDefaultDialog: false,
						resetBerkasDialog: false,
						changePasswordOpenDialog: false,
						// Json
						passwordAfter:'',
                        passwordAfterConfirmation:'',
						listUnverifiedUsers: [],
						selectedForVerify: [],
						listMahasiswa: [],
						listDosen: [],
						user: {
							id:null,
							nomor:'',
							nama:'',
						},
						userDefault: {
							id:null,
							nomor:'',
							nama:'',
						},
						event: [],
						mahasiswa: {
							id:null,
							nama:'',
							nomor:'',
							password:'',
							judul:'',
							id_dosen_pembimbing:null,
							id_ketua_penguji:null,
							id_dosen_penguji:null
						},
						mahasiswaDefault: {
							id:null,
							nama:'',
							nomor:'',
							password:'',
							judul:'',
							id_dosen_pembimbing:null,
							id_ketua_penguji:null,
							id_dosen_penguji:null
						},
						// Snackbar goes here
                        snackbar: false,
                        snackbarMessage: '',
                        snackbarColor: '',
						// Rules
						rules: {
							nomor: [
								v => !!v || 'NIP / NIM Wajib diisi',
                                v => /^[0-9]*$/.test(v) || 'NIP / NIM Harus berupa angka'
							],
							nama: [
								v => !!v || 'Nama Wajib diisi',
							],
							email: [
								v => !!v || 'E-mail is required',
        						v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
							],
							passwordAfter: [
								v => !!v || 'Password Wajib diisi',
                                v => v == this.passwordAfter || 'Password Konfirmasi Harus Sama Dengan Password Baru',
								v => v.length>=8 || 'Minimal 8 Karakter',
							],
							passwordConfirm: [
								v => !!v || 'Password Wajib diisi',
                                v => v == this.passwordAfter || 'Password Konfirmasi Harus Sama Dengan Password Baru',
							]
						},
						// etc
						selectedIndex:-1,
						showPassword: false,
					}
				},

				methods: {
					goToSkripsi() {
                        window.open(this.mahasiswa.berkas[0].skripsi_file, '_blank');
                    },
                    goToToefl() {
                        window.open(this.mahasiswa.berkas[0].toefl_file, '_blank');
                    },
                    goToTranskrip() {
                        window.open(this.mahasiswa.berkas[0].transkrip_file, '_blank');
                    },
                    goToBimbingan() {
                        window.open(this.mahasiswa.berkas[0].bimbingan_file, '_blank');
                    },
					verify(which_one,is_pass) {
                        return new Promise((resolve, reject) => {
                            if(which_one == 'skripsi_file_verified') {
                                var data = {id: this.mahasiswa.berkas[0].id, skripsi_file_verified_ketua_penguji: is_pass}
                            } else {
                                if(which_one == 'toefl_file_verified') {
                                    var data = {id: this.mahasiswa.berkas[0].id, toefl_file_verified: is_pass}
                                } else {
                                    if(which_one == 'transkrip_file_verified') {
                                        var data = {id: this.mahasiswa.berkas[0].id, transkrip_file_verified: is_pass}
                                    } else {
                                        if(which_one == 'bimbingan_file_verified') {
                                            var data = {id: this.mahasiswa.berkas[0].id, bimbingan_file_verified: is_pass}
                                        }
                                    }
                                }
                            }
                            axios.put('<?= base_url()?>api/Berkas',data)
                                .then((response) => {
                                    resolve(response.data)
                                }) .catch((err) => {
                                    if(err.response.status == 500) reject('Server Error')
                                })
                        }) .then((response) => {
                            this.snackbarMessage = response.message
                            this.snackbarColor = 'success'
                        }) .catch(err => {
                            this.snackbarMessage = err
                            this.snackbarColor = 'error'
                        }) .finally(() => {
                            this.snackbar = true
                            this.get()
                            if(which_one == 'skripsi_file_verified') {
                                this.mahasiswa.berkas[0].skripsi_file_verified_ketua_penguji = is_pass
                            } else {
                                if(which_one == 'toefl_file_verified') {
                                    this.mahasiswa.berkas[0].toefl_file_verified = is_pass
                                } else {
                                    if(which_one == 'transkrip_file_verified') {
                                        this.mahasiswa.berkas[0].transkrip_file_verified = is_pass
                                    } else {
                                        if(which_one == 'bimbingan_file_verified') {
                                            this.mahasiswa.berkas[0].bimbingan_file_verified = is_pass
                                        }
                                    }
                                }
                            }
                        })
                    },
					resetBerkas() {
						return new Promise((resolve, reject) => {
							let data = {
								id_mahasiswa: this.mahasiswa.id,
								reset: 1
							}
							axios.put('<?= base_url()?>api/Berkas', data)
							.then(response => {
										resolve(response.data)
									}) .catch(err => {
										if(err.response.status == 500) reject(err.response.data)
									})
						})
						.then((response) => {
							this.snackbarMessage = response.message
							this.snackbarColor = 'success'
						}) .catch(err => {
							this.snackbarMessage = err.message
							this.snackbarColor = 'error'
							this.snackbar = true
						}) .finally(() => {
							this.snackbar = true
							this.get()
							this.resetBerkasDialog = false
						})
					},
					changePasswordDefault() {
						return new Promise((resolve, reject) => {
							let data = {
								id: this.mahasiswa.id,
								password: this.mahasiswa.nomor
							}
							axios.put('<?= base_url()?>api/User', data)
							.then(response => {
										resolve(response.data)
									}) .catch(err => {
										if(err.response.status == 500) reject(err.response.data)
									})
						})
						.then((response) => {
							this.snackbarMessage = response.message
							this.snackbarColor = 'success'
						}) .catch(err => {
							this.snackbarMessage = err.message
							this.snackbarColor = 'error'
							this.snackbar = true
						}) .finally(() => {
							this.snackbar = true
							this.get()
							this.changePasswordDefaultDialog = false
						})
					},
					detailMahasiswa(item) {
						this.selectedIndex = this.listMahasiswa.indexOf(item)
						this.mahasiswa = Object.assign({},item)
						this.detailMahasiswaDialog = true
					},
					dayFormat(date) {
						let i = new Date(date).getDay(date)
						var dayOftheWeek = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su']
						return dayOftheWeek[i]
					},
					get() {
						return new Promise((resolve, reject) => {
                            axios.get('<?= base_url()?>api/User',{params: {verif: 1}})
                                .then(response => {
                                    resolve(response.data)
                                }) .catch(err => {
                                    if(err.response.status == 500) reject('Server Error')
                                })
                        })
                        .then((response) => {
                            this.listUnverifiedUsers = response
                        })
						.then(() => {
							return new Promise((resolve, reject) => {
								axios.get('<?= base_url()?>api/Time')
								.then(response => {
                                    resolve(response.data)
                                }) .catch(err => {
                                    if(err.response.status == 500) reject('Server Error')
                                })
							})
							.then((response) => {
								this.event = response
							})
						})
						.then(() => {
							return new Promise((resolve, reject) => {
								axios.get('<?= base_url()?>api/User')
									.then(response => {
										resolve(response.data)
									}) .catch(err => {
										if(err.response.status == 500) reject('Server Error')
									})
							})
							.then((response) => {
								this.listMahasiswa = response
							})
						})
						.then(() => {
							return new Promise((resolve, reject) => {
								axios.get('<?= base_url()?>api/DosenList')
									.then((response) => {
										resolve(response.data)
									}) .catch((err) => {
										if(err.response.status == 500) reject('Server Error')
									})
							})
							.then((response) => {
								this.listDosen = response
							})
						})
						
					},
                    logOut() {
                        window.location.href = '<?=base_url('Pages/logOut');?>'
                    },
					verifyNow() {
						return new Promise((resolve, reject) => {
							let data = {
								users: this.selectedForVerify
							}
                            axios.put('<?= base_url()?>api/Admin',data)
                                .then(response => {
                                    resolve(response.data)
                                }) .catch(err => {
                                    if(err.response.status == 500) reject('Server Error')
                                })
                        }) .then((response) => {
                            this.snackbarMessage = response.message
                            this.snackbarColor = 'success'
                        }) .catch(err => {
                            this.snackbarMessage = err
                            this.snackbarColor = 'error'
                        }) .finally(() => {
                            this.snackbar = true
                            this.get()
                        })
					},
					close() {
						if(this.verifikasiDialog) {
							this.verifikasiDialog = false
						} else {
							if(this.createNewDosenDialog) {
								this.createNewDosenDialog = false
								this.user = Object.assign({},this.userDefault)
							} else {
								if(this.eventSidangDialog) {
									this.eventSidangDialog = false
								} else {
									if(this.listMahasiswaDialog && !this.detailMahasiswaDialog) {
										this.listMahasiswaDialog = false
									} else {
										if(this.detailMahasiswaDialog) {
											this.detailMahasiswaDialog = false
											this.mahasiswa = Object.assign({},this.mahasiswaDefault)
										} else {
											if(this.changePasswordOpenDialog) {
												this.changePasswordOpenDialog = false
												this.passwordAfter = ''
												this.passwordAfterConfirmation = ''
											}
										}
									}
								}
							}
						}
					},
					createNewUser() {
						if(this.$refs.form.validate()) {
							return new Promise((resolve, reject) => {
								axios.post('<?= base_url()?>api/Dosen',this.user)
									.then(response => {
										resolve(response.data)
									}) .catch(err => {
										if(err.response.status == 500) reject(err.response.data)
										if(err.response.status == 401) reject(err.response.data)
									})
							})
							.then((response) => {
								this.snackbarMessage = response.message
                            	this.snackbarColor = 'success'
							}) .catch(err => {
								if(err.message == "NIP already exists.") {
									this.snackbarMessage = err.message
									this.snackbarColor = 'warning'
								} else {
									this.snackbarMessage = err
									this.snackbarColor = 'error'
									this.snackbar = true
								}
							}) .finally(() => {
								this.snackbar = true
								this.get()
								this.user = Object.assign({},this.userDefault)
								// this.close()
							})
						}
					},
					updateEvent() {
						return new Promise((resolve, reject) => {
							let data = {
								tanggal_mulai:this.event[0].tanggal_mulai,
								tanggal_berakhir:this.event[0].tanggal_berakhir
							}
							axios.put('<?= base_url()?>api/Time',data)
								.then(response => {
									resolve(response.data)
								}) .catch(err => {
									if(err.response.status == 500) reject(err.response.data)
								})
						})
						.then((response) => {
							this.snackbarMessage = response.message
							this.snackbarColor = 'success'
						}) .catch(err => {
							this.snackbarMessage = err
							this.snackbarColor = 'error'
						}) .finally(() => {
							this.snackbar = true
							this.get()
							this.close()
						})
					},
					updateMahasiswa() {
						return new Promise((resolve, reject) => {
							this.mahasiswa.password = null
							axios.put('<?= base_url()?>api/User',this.mahasiswa)
								.then(response => {
									resolve(response.data)
								}) .catch(err => {
									if(err.response.status == 500) reject(err.response.data)
								})
						})
						.then((response) => {
							this.snackbarMessage = response.message
							this.snackbarColor = 'success'
						}) .catch(err => {
							this.snackbarMessage = err
							this.snackbarColor = 'error'
						}) .finally(() => {
							this.snackbar = true
							this.get()
							this.close()
						})
					},
					changePasswordOpenDialogFunc() {
                        this.changePasswordOpenDialog = true
                    },
                    changePassword() {
                        if(this.$refs.formPassword.validate()) {
                            return new Promise((resolve, reject) => {
                                let data = {
                                    id: <?=$id;?>,
                                    password: this.passwordAfter
                                }
                                axios.put('<?= base_url()?>api/Admin_Password', data)
                                    .then(response => {
                                                resolve(response.data)
                                            }) .catch(err => {
                                                if(err.response.status == 500) reject(err.response.data)
                                            })
                            })
                            .then((response) => {
                                this.snackbarMessage = response.message
                                this.snackbarColor = 'success'
                            }) .catch(err => {
                                this.snackbarMessage = err
                                this.snackbarColor = 'error'
                            }) .finally(() => {
                                this.snackbar = true
                                this.get()
                                this.close()
                            })
                        }
                    },
					dateFormat(val) {
                        return val ? moment(val).format('DD MMMM YYYY') : ''
                    },
				},
				
				computed: {
                    popUpBreakPoint() {
                        if (this.$vuetify.breakpoint.name == 'xs') {
                            return true
                        } else {
                            return false
                        }
                    },
					verifikasiHeader() {
						return [
							{text:'NIM', value:'nomor'},
							{text:'Nama', value:'nama'},
							{text:'Tanggal Registrasi', value:'date'},
						]
					},
					mahasiswaHeader() {
						return [
							{text:'NIM', value:'nomor'},
							{text:'Nama', value:'nama'},
						]
					},
					formatDate() {
						return this.event[0].tanggal_mulai ? moment(this.event[0].tanggal_mulai).format('DD MMMM YYYY') : ''
					},
					formatDateEnd() {
						return this.event[0].tanggal_berakhir ? moment(this.event[0].tanggal_berakhir).format('DD MMMM YYYY') : ''
					}
				}

			})
		</script>
	</body>

</html>
