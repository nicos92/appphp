

Correcto, `TIMESTAMP` incluye hora, minutos y segundos, lo que impide que la restricción `UNIQUE` funcione como esperas. Para resolverlo, debes crear un campo fecha **`DATE`** adicional que guarde solo la fecha (sin hora) y aplicar la restricción `UNIQUE` a ese campo junto con `codigo_barras`.

## Pasos

1.  Agregar un nuevo campo `fecha DATE` a la tabla.
2.  Actualizar los registros existentes para que `fecha` tenga el valor de `fecha_registro` (sin hora).
3.  Aplicar la restricción `UNIQUE` en `codigo_barras` y `fecha`.
4.  (Opcional) Eliminar la restricción en `fecha_registro` si ya no se necesita.

---

## Comandos SQL

1.  Agregar campo `fecha DATE`:

```sql
ALTER TABLE tarimas ADD COLUMN fecha DATE;
````

2.  Actualizar registros existentes (copiar valor de `fecha_registro` a `fecha`):

<!-- end list -->

```sql
UPDATE tarimas SET fecha = DATE(fecha_registro);
```

3.  Aplicar restricción `UNIQUE` (en `codigo_barras` y `fecha`):

<!-- end list -->

```sql
ALTER TABLE tarimas ADD UNIQUE (codigo_barras, fecha);
```

4.  (Opcional) Eliminar `UNIQUE` en `fecha_registro` (si ya no se necesita):

<!-- end list -->

```sql
ALTER TABLE tarimas DROP INDEX codigo_barras_fecha_registro_unique;
```

-----

## Consideraciones

  * Asegúrate de que `fecha_registro` se actualice automáticamente si se modifica `fecha` (y viceversa) para mantener consistencia.
  * Si estás insertando registros con `fecha_registro` actual (`DEFAULT`), asegúrate de que `fecha` también se establezca correctamente (sin hora).
  * Si ya existen registros duplicados en `codigo_barras` y `fecha_registro`, los pasos anteriores fallarán. **Debes eliminar duplicados antes de aplicar la restricción.**

-----

Para especificar que una columna de tipo `DATE` en MySQL tenga por defecto la fecha en la que se realiza la inserción, debes usar la cláusula **`DEFAULT (CURRENT_DATE())`** en la definición de la columna.

## Uso en `CREATE TABLE`

```sql
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto VARCHAR(100) NOT NULL,
    cantidad INT NOT NULL,
    -- La columna 'fecha_pedido' tomará la fecha actual por defecto
    fecha_pedido DATE DEFAULT (CURRENT_DATE())
);


     Para especificar que una columna de tipo `DATE` en MySQL tenga por defecto la fecha en la que se realiza la inserción, debes usar la cláusula **`DEFAULT (CURRENT_DATE())`** en la definición de la columna.

Aquí tienes un ejemplo de cómo se vería en una sentencia `CREATE TABLE`:

## Uso en `CREATE TABLE`

```sql
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto VARCHAR(100) NOT NULL,
    cantidad INT NOT NULL,
    -- La columna 'fecha_pedido' tomará la fecha actual por defecto
    fecha_pedido DATE DEFAULT (CURRENT_DATE())
);
```

-----

## Uso en `ALTER TABLE`

Si la tabla ya existe y deseas modificar una columna existente (o agregar una nueva columna) para que tenga este comportamiento por defecto, usarías `ALTER TABLE`:

### Para agregar una nueva columna:

```sql
ALTER TABLE mi_tabla
ADD COLUMN fecha_registro DATE DEFAULT (CURRENT_DATE());
```

### Para modificar una columna existente:

```sql
ALTER TABLE mi_tabla
ALTER COLUMN fecha_columna SET DEFAULT (CURRENT_DATE());
```

### **Importante:**

  * **`DATE` vs. `DATETIME` / `TIMESTAMP`**: Usas **`CURRENT_DATE()`** porque tu columna es de tipo **`DATE`** (solo almacena la fecha).
  * Si tu columna fuera de tipo `DATETIME` o `TIMESTAMP` (que almacenan fecha y hora), usarías **`DEFAULT CURRENT_TIMESTAMP`** o **`DEFAULT NOW()`** para obtener la fecha y hora exactas de la inserción.
      * *Ejemplo para `DATETIME`/`TIMESTAMP`:* `fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP`
