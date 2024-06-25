using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Xamarin.Forms;
using SQLite;
using App111.Models;



namespace App111
{
    public partial class MainPage : ContentPage
    {
        public MainPage()
        {
            InitializeComponent();
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
                var CvDatos = await App.SQLiteDB.GetDataAsync();
                if (CvDatos != null)
                {
                    listViewCVs.ItemsSource = CvDatos;

                }
            }
            else
            {
                await DisplayAlert("Error", "Ingresar todos los datos", "Ok");
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
    }
}
