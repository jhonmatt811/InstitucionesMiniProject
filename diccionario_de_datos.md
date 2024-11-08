# Esquema de Tablas

---

## Tabla: `acto_admon`

| Columna       | Tipo de Dato       | Longitud | Nulo | Predeterminado | Descripción | Dominio |
|---------------|--------------------|----------|------|----------------|-------------|---------|
| nomb_admon    | character varying  | 50       | YES  | -              | -           | -       |
| cod_admon     | character varying  | 8        | NO   | -              | -           | -       |

---

## Tabla: `acto_nombramiento`

| Columna          | Tipo de Dato       | Longitud | Nulo | Predeterminado | Descripción | Dominio |
|------------------|--------------------|----------|------|----------------|-------------|---------|
| cod_nombram      | character varying  | 15       | NO   | -              | -           | -       |
| nomb_nombram     | character varying  | 100      | YES  | -              | -           | -       |
| fecha_nombram    | date               | -        | YES  | -              | -           | -       |

---

## Tabla: `caracter_academico`

| Columna    | Tipo de Dato       | Longitud | Nulo | Predeterminado | Descripción | Dominio |
|------------|--------------------|----------|------|----------------|-------------|---------|
| nomb_academ| character varying  | 50       | YES  | -              | -           | -       |
| cod_academ | character varying  | 8        | NO   | -              | -           | -       |

---

## Tabla: `cargos`

| Columna       | Tipo de Dato       | Longitud | Nulo | Predeterminado | Descripción | Dominio |
|---------------|--------------------|----------|------|----------------|-------------|---------|
| nomb_cargo    | character varying  | 50       | YES  | -              | -           | -       |
| cod_cargo     | character varying  | 8        | NO   | -              | -           | -       |

---

## Tabla: `cobertura`

| Columna         | Tipo de Dato       | Longitud | Nulo | Predeterminado | Descripción | Dominio |
|-----------------|--------------------|----------|------|----------------|-------------|---------|
| munic_por_cubrim| character varying  | 8        | NO   | -              | -           | -       |
| cod_cubrim      | character varying  | 8        | NO   | -              | -           | -       |
| cod_munic       | character varying  | 8        | NO   | -              | -           | -       |
| cod_inst        | integer            | 32       | NO   | -              | -           | -       |

---

## Tabla: `cubrimiento`

| Columna          | Tipo de Dato       | Longitud | Nulo | Predeterminado | Descripción | Dominio |
|------------------|--------------------|----------|------|----------------|-------------|---------|
| tipo_cubrimiento | character varying  | 30       | YES  | -              | -           | -       |
| cod_cubrim       | character varying  | 8        | NO   | -              | -           | -       |

---

## Tabla: `departamentos`

| Columna    | Tipo de Dato       | Longitud | Nulo | Predeterminado | Descripción | Dominio |
|------------|--------------------|----------|------|----------------|-------------|---------|
| nomb_depto | character varying  | 80       | YES  | -              | -           | -       |
| cod_depto  | character varying  | 9        | NO   | -              | -           | -       |

---

## Tabla: `directivos`

| Columna           | Tipo de Dato       | Longitud | Nulo | Predeterminado | Descripción | Dominio |
|-------------------|--------------------|----------|------|----------------|-------------|---------|
| nomb_directivo    | character varying  | 30       | YES  | -              | -           | -       |
| cod_directivo     | character varying  | 8        | NO   | -              | -           | -       |
| apellido_directivo| character varying  | 30       | YES  | -              | -           | -       |

---

## Tabla: `estados`

| Columna     | Tipo de Dato       | Longitud | Nulo | Predeterminado | Descripción | Dominio |
|-------------|--------------------|----------|------|----------------|-------------|---------|
| cod_estado  | character varying  | 7        | NO   | -              | -           | -       |
| nomb_estado | character varying  | 30       | YES  | -              | -           | -       |

---

## Tabla: `inst_por_municipio`

| Columna                | Tipo de Dato       | Longitud | Nulo | Predeterminado | Descripción | Dominio |
|------------------------|--------------------|----------|------|----------------|-------------|---------|
| cod_norma              | character varying  | 8        | YES  | -              | -           | -       |
| norma                  | character varying  | 20       | YES  | -              | -           | -       |
| pagina_web             | text               | -        | YES  | -              | -           | -       |
| cod_estado             | character varying  | 7        | YES  | -              | -           | -       |
| cod_seccional          | character varying  | 8        | YES  | -              | -           | -       |
| vigencia               | integer            | 32       | YES  | -              | -           | -       |
| cod_munic              | character varying  | 8        | NO   | -              | -           | -       |
| cod_juridica           | character varying  | 9        | YES  | -              | -           | -       |
| nit                    | character varying  | 50       | YES  | -              | -           | -       |
| resolucion_acreditacion| integer            | 32       | YES  | -              | -           | -       |
| telefono               | character varying  | 50       | YES  | -              | -           | -       |
| cod_admon              | character varying  | 8        | YES  | -              | -           | -       |
| cod_inst               | integer            | 32       | NO   | -              | -           | -       |
| mision                 | text               | -        | YES  | -              | -           | -       |
| direccion              | character varying  | 150      | YES  | -              | -           | -       |
| programas_vigente      | integer            | 32       | YES  | -              | -           | -       |
| fecha_acreditacion     | date               | -        | YES  | -              | -           | -       |
| acreditada             | character varying  | 2        | YES  | -              | -           | -       |
| fecha_creacion         | date               | -        | YES  | -              | -           | -       |

---

## Tabla: `instituciones`

| Columna    | Tipo de Dato       | Longitud | Nulo | Predeterminado | Descripción | Dominio |
|------------|--------------------|----------|------|----------------|-------------|---------|
| cod_inst   | integer            | 32       | NO   | -              | -           | -       |
| cod_sector | character varying  | 10       | YES  | -              | -           | -       |
| cod_academ | character varying  | 8        | YES  | -              | -           | -       |
| nomb_inst  | character varying  | 150      | YES  | -              | -           | -       |

---

## Tabla: `municipios`

| Columna    | Tipo de Dato       | Longitud | Nulo | Predeterminado | Descripción | Dominio |
|------------|--------------------|----------|------|----------------|-------------|---------|
| cod_munic  | character varying  | 8        | NO   | -              | -           | -       |
| nomb_munic | character varying  | 30       | YES  | -              | -           | -       |
| cod_depto  | character varying  | 9        | YES  | -              | -           | -       |

---

## Tabla: `naturaleza_juridica`

| Columna       | Tipo de Dato       | Longitud | Nulo | Predeterminado | Descripción | Dominio |
|---------------|--------------------|----------|------|----------------|-------------|---------|
| nomb_juridica | character varying  | 30       | YES  | -              | -           | -       |
| cod_juridica  | character varying  | 9        | NO   | -              | -           | -       |

---

## Tabla: `norma_creacion`

| Columna    | Tipo de Dato       | Longitud | Nulo | Predeterminado | Descripción | Dominio |
|------------|--------------------|----------|------|----------------|-------------|---------|
| cod_norma  | character varying  | 8        | NO   | -              | -           | -       |
| nomb_norma | character varying  | 30       | YES  | -              | -           | -       |

---

## Tabla: `rectoria`

| Columna       | Tipo de Dato       | Longitud | Nulo | Predeterminado | Descripción | Dominio |
|---------------|--------------------|----------|------|----------------|-------------|---------|
| cod_munic     | character varying  | 8        | NO   | -              | -           | -       |
| cod_inst      | integer            | 32       | NO   | -              | -           | -       |
| cod_nombram   | character varying  | 15       | YES  | -              | -           | -       |
| cod_cargo     | character varying  | 8        | NO   | -              | -           | -       |
| cod_directivo | character varying  | 8        | NO   | -              | -           | -       |
| fecha_inico   | date               | -        | YES  | -              | -           | -       |
| fecha_final   | date               | -        | YES  | -              | -           | -       |

---

## Tabla: `seccional`

| Columna        | Tipo de Dato       | Longitud | Nulo | Predeterminado | Descripción | Dominio |
|----------------|--------------------|----------|------|----------------|-------------|---------|
| cod_seccional  | character varying  | 8        | NO   | -              | -           | -       |
| nomb_seccional | character varying  | 30       | YES  | -              | -           | -       |

---

## Tabla: `sectores`

| Columna     | Tipo de Dato       | Longitud | Nulo | Predeterminado | Descripción | Dominio |
|-------------|--------------------|----------|------|----------------|-------------|---------|
| cod_sector  | character varying  | 10       | NO   | -              | -           | -       |
| nomb_sector | character varying  | 30       | YES  | -              | -           | -       |

---

