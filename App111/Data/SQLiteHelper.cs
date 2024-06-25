﻿using System;
using System.Collections.Generic;
using System.Text;
using SQLite;
using App111.Models;
using System.Threading.Tasks;


namespace App111.Data
{
    public class SQLiteHelper

    {
        SQLiteAsyncConnection db;
        public SQLiteHelper(string dbPath)
        {
            db = new SQLiteAsyncConnection(dbPath);
            db.CreateTableAsync<CVData>().Wait();
        }

        public Task<int> SaveCVDataAsync(CVData cvData)
        {
            if (cvData.Id == 0)
            {
                return db.InsertAsync(cvData);
            }
            else
            {
                return null;
            }
        }

        public Task<List<CVData>> GetDataAsync()
        {
            return db.Table<CVData>().ToListAsync();
        }

        /// <summary>
        /// Recuperar datos por id
        /// </summary>
        /// <param name="idCV"></param>
        /// <returns></returns>
        public Task<CVData> GetCVDataByIdAsync(int idCV)
        {
            return db.Table<CVData>().Where(a => a.Id == idCV).FirstOrDefaultAsync();

        }

    }
}

