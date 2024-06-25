using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Xamarin.Forms;
using SQLite;
using App111.Models;
using System.Xml.Linq;
using System.Security.Cryptography.X509Certificates;



namespace App111
{
    public partial class MainPage : ContentPage
    {
        public MainPage()
        {
            InitializeComponent();
            llenarDatos();
        }

        private async void EnviarCV_Clicked(object sender, EventArgs e)
        {
            if (validarDatos())
            {
                CVData cvData = new CVData()
                {
                    NombreCompleto = entryNombre.Text,
                    CorreoElectronico = entryCorreo.Text,
                    NumeroTelefono = int.Parse(entryTelefono.Text),
                    Direccion = entryDireccion.Text,
                    ExperienciaLaboral = editorExperiencia.Text,
                    Educacion = editorEducacion.Text,
                    Habilidades = editorHabilidades.Text
                };
                await App.SQLiteDB.SaveCVDataAsync(cvData);
                entryNombre.Text = "";
                entryCorreo.Text = "";
                entryTelefono.Text = "";
                entryDireccion.Text = "";
                editorExperiencia.Text = "";
                editorEducacion.Text = "";
                editorHabilidades.Text = "";
                await DisplayAlert("Registro", "Datos guardados con exito", "Ok");
                llenarDatos();

            }
            else
            {
                await DisplayAlert("Error", "Ingresar todos los datos", "Ok");
            }
        }

        public async void llenarDatos()
        {
            var CvDatos = await App.SQLiteDB.GetDataAsync();
            if (CvDatos != null)
            {
                listViewCVs.ItemsSource = CvDatos;

            }
        }

        public bool validarDatos()
        {
            bool respuesta;
            if (string.IsNullOrEmpty(entryNombre.Text))
            {
                respuesta = false;

            }

            else if (string.IsNullOrEmpty(entryCorreo.Text))
            {
                respuesta = false;

            }

            else if (string.IsNullOrEmpty(entryTelefono.Text))
            {
                respuesta = false;

            }

            else if (string.IsNullOrEmpty(entryDireccion.Text))
            {
                respuesta = false;

            }

            else if (string.IsNullOrEmpty(editorExperiencia.Text))
            {
                respuesta = false;

            }

            else if (string.IsNullOrEmpty(editorEducacion.Text))
            {
                respuesta = false;

            }

            else if (string.IsNullOrEmpty(editorHabilidades.Text))
            {
                respuesta = false;

            }

            else
            {
                respuesta = true;
            }
            return respuesta;
        }

        private async void listViewCVs_ItemSelected(object sender, SelectedItemChangedEventArgs e)
        {
            if (e.SelectedItem == null)
                return;

            var selectedCV = (CVData)e.SelectedItem;
            entryId.Text = selectedCV.Id.ToString();
            entryNombre.Text = selectedCV.NombreCompleto;
            entryCorreo.Text = selectedCV.CorreoElectronico;
            entryTelefono.Text = selectedCV.NumeroTelefono.ToString();
            entryDireccion.Text = selectedCV.Direccion;
            editorExperiencia.Text = selectedCV.ExperienciaLaboral;
            editorEducacion.Text = selectedCV.Educacion;
            editorHabilidades.Text = selectedCV.Habilidades;

            btnRegistrar.IsVisible = false;
            entryId.IsVisible = true;
            btnActualizar.IsVisible = true;
            btnEliminar.IsVisible = true;
        }

        private async void ActualizarCV_Clicked(object sender, EventArgs e)
        {
            if (!string.IsNullOrEmpty(entryId.Text))
            {
                CVData cvData = new CVData()
                {
                    Id = Convert.ToInt32(entryId.Text),
                    NombreCompleto = entryNombre.Text,
                    CorreoElectronico = entryCorreo.Text,
                    NumeroTelefono = Convert.ToInt32(entryTelefono.Text),
                    Direccion = entryDireccion.Text,
                    ExperienciaLaboral = editorExperiencia.Text,
                    Educacion = editorEducacion.Text,
                    Habilidades = editorHabilidades.Text
                };

                await App.SQLiteDB.SaveCVDataAsync(cvData);

                await DisplayAlert("Actualización", "Datos actualizados con éxito", "Ok");

                LimpiarControles();
                llenarDatos();
            }
            else
            {
                await DisplayAlert("Error", "Seleccione un CV para actualizar", "Ok");
            }
        }

        private async void btnEliminar_Clicked(object sender, EventArgs e)
        {
            if (!string.IsNullOrEmpty(entryId.Text))
            {
                var cVData = await App.SQLiteDB.GetCVDataByIdAsync(Convert.ToInt32(entryId.Text));
                if (cVData != null)
                {
                    await App.SQLiteDB.DeleteBaseAsync(cVData);
                    await DisplayAlert("Eliminado", "CV eliminado exitosamente", "Ok");
                    LimpiarControles();
                    llenarDatos();
                }
            }
            else
            {
                await DisplayAlert("Error", "Seleccione un CV para eliminar", "Ok");
            }
        }


        private void LimpiarControles()
        {
            entryId.Text = "";
            entryNombre.Text = "";
            entryCorreo.Text = "";
            entryTelefono.Text = "";
            entryDireccion.Text = "";
            editorExperiencia.Text = "";
            editorEducacion.Text = "";
            editorHabilidades.Text = "";

            btnRegistrar.IsVisible = true;
            entryId.IsVisible = false;
            btnActualizar.IsVisible = false;
            btnEliminar.IsVisible = false;

            listViewCVs.SelectedItem = null;
        }
    }
}