using System;
using System.Collections.Generic;
using System.Text;
using SQLite;

namespace App111.Models
{
    public class CVData
    {
        [PrimaryKey, AutoIncrement]
        public int Id { get; set; }

        [MaxLength(50)]
        public string NombreCompleto { get; set; }

        [MaxLength(50)]
        public string CorreoElectronico { get; set; }

        [MaxLength(60)]
        public int NumeroTelefono { get; set; }

        public string Direccion { get; set; }

        [MaxLength(50)]
        public string ExperienciaLaboral { get; set; }

        [MaxLength(50)]
        public string Educacion { get; set; }

        [MaxLength(50)]
        public string Habilidades { get; set; }
    }
}

